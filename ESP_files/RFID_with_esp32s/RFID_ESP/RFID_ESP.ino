#include <ESPAsyncWebSrv.h>
#include <WiFi.h>
#include <SPI.h>//https://www.arduino.cc/en/reference/SPI
#include <MFRC522.h>//https://github.com/miguelbalboa/rfid
#include <HTTPClient.h>

const char* ssid = "raspberrySmarthome";
const char* password = "huu1vi9doL";

#define led_r 26
#define led_g 33
#define led_b 25
#define SS_PIN 5
#define RST_PIN 27

String ipEnd = "7";
IPAddress local_IP(192,168,200,7);
IPAddress gateway(192,168,200,1);
IPAddress subnet(255,255,255,0);

const char *host = "http://192.168.200.1/api/rfid"; //api route for data sending to the Laravel app

MFRC522 mfrc522(SS_PIN, RST_PIN);  //--> Create MFRC522 instance.

AsyncWebServer webserver(80);  

int readsuccess;
int state = 0; // 0 = continous reading 1 = add tag to text field
byte readcard[4];
char str[32] = "";
String StrUID;
String StrUIDforReg;

//-----------------------------------------------------------------------------------------------SETUP--------------------------------------------------------------------------------------//
void setup() {
  Serial.begin(9600); 
  SPI.begin();        //--> Init SPI bus
  mfrc522.PCD_Init(); //--> Init MFRC522 card

  delay(500);
  pinMode(led_r,OUTPUT);
  pinMode(led_g,OUTPUT);
  pinMode(led_b,OUTPUT);
  RGB_color(0,0,50);

    if(!WiFi.config(local_IP,gateway,subnet)){
    Serial.println("STA failed to configure");
  }
    WiFi.mode(WIFI_OFF);        
    delay(1000);
    WiFi.mode(WIFI_STA);
    
    WiFi.begin(ssid, password); //--> Connect to your WiFi router
    Serial.println("");

  //----------------------------------------Wait for connection
  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    //----------------------------------------Make the On Board Flashing LED on the process of connecting to the wifi router.
    RGB_color(0,0,10);
    delay(250);
    RGB_color(0,0,50);
    delay(250);
  }
   RGB_color(0,0,0); 
  //----------------------------------------If successfully connected to the wifi router, the IP Address that will be visited is displayed in the serial monitor
  Serial.println("");
  Serial.print("Successfully connected to : ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

  Serial.println("Please tag a card or keychain to see the UID !");
  Serial.println("");

  webserver.on("/read",HTTP_GET, [](AsyncWebServerRequest * request) {
    state = 1;
    while(StrUIDforReg == ""){
      readData();
    }
    String temp_res ="{\"uid\":\"";
    temp_res += StrUIDforReg;
    temp_res += "\"}";

    request->send(200, "application/json", temp_res);
    StrUIDforReg = "";
    state = 0;
  });
  webserver.on("/state/0",HTTP_GET, [](AsyncWebServerRequest * request) {
    state = 0;
  });
  webserver.begin();
}


void loop() {
      readData();
}

void RGB_color(int R, int G, int B)
 {
  analogWrite(led_r, R);
  analogWrite(led_g, G);
  analogWrite(led_b, B);
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//----------------------------------------Procedure for reading and obtaining a UID from a card or keychain---------------------------------------------------------------------------------//

void readData(){
  readsuccess = getid();

  if (readsuccess) {
    RGB_color(0, 50, 50);

    String UIDresultSend, postData;
     switch(state){
      case 0:
        UIDresultSend = StrUID;
        break;
      case 1:
        UIDresultSend = StrUIDforReg;
        break;
    }

if(state == 0){
  HTTPClient http;
  //Prepare data

  postData =  "ipEnd=" + ipEnd + "&uid=" + StrUID;
  http.begin(host);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.POST(postData);
  String payload = http.getString();
  //Serial.println(postData);
  //Serial.println(httpCode);
  //Serial.println(payload);
  http.end();
  delay(1000);
  if(payload == "OK" && httpCode == 200){
    responseBlink(0);
  }
  else if(payload == "FAIL" && httpCode == 200){
    responseBlink(1);
  }
  else{
    Serial.println(httpCode);
    Serial.println(payload);
  }
  RGB_color(0,0,0);
}
    Serial.println(UIDresultSend);
    delay(1000);
    RGB_color(0,0,0);
  }
}
void responseBlink(int res){   
  int del = 300; 
  if(res == 0){
      RGB_color(0,200,0);
      delay(del);
      RGB_color(0,20,0);
      delay(del);
      RGB_color(0,200,0);
      delay(del);
      RGB_color(0,20,0);
      delay(del);
      RGB_color(0,200,0);
      delay(del);
      RGB_color(0,20,0);
      delay(del);
      RGB_color(0,200,0);
      delay(del);
  }
  else if(res == 1){
      RGB_color(200,0,0);
      delay(del);
      RGB_color(20,0,0);
      delay(del);
      RGB_color(200,0,0);
      delay(del);
      RGB_color(20,0,0);
      delay(del);
      RGB_color(200,0,0);
      delay(del);
      RGB_color(20,0,0);
      delay(del);
      RGB_color(200,0,0);
      delay(del);
  }
      
}


int getid() {
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return 0;
  }
  if (!mfrc522.PICC_ReadCardSerial()) {
    return 0;
  }

  Serial.print("THE UID OF THE SCANNED CARD IS : ");

  for (int i = 0; i < 4; i++) {
    readcard[i] = mfrc522.uid.uidByte[i]; //storing the UID of the tag in readcard
    array_to_string(readcard, 4, str);
    switch(state){
      case 0:
        StrUID = str;
        break;
      case 1:
        StrUIDforReg = str;
        break;
    }
  }
  mfrc522.PICC_HaltA();
  return 1;
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//----------------------------------------Procedure to change the result of reading an array UID into a string------------------------------------------------------------------------------//
void array_to_string(byte array[], unsigned int len, char buffer[]) {
  for (unsigned int i = 0; i < len; i++)
  {
    byte nib1 = (array[i] >> 4) & 0x0F;
    byte nib2 = (array[i] >> 0) & 0x0F;
    buffer[i * 2 + 0] = nib1  < 0xA ? '0' + nib1  : 'A' + nib1  - 0xA;
    buffer[i * 2 + 1] = nib2  < 0xA ? '0' + nib2  : 'A' + nib2  - 0xA;
  }
  buffer[len * 2] = '\0';
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//