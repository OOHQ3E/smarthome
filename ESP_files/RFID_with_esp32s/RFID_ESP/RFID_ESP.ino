#include <ESPAsyncWebSrv.h>
#include <WiFi.h>
#include <SPI.h>//https://www.arduino.cc/en/reference/SPI
#include <MFRC522.h>//https://github.com/miguelbalboa/rfid
#include <HTTPClient.h>

const char* ssid = "raspberrySmarthome";
const char* password = "huu1vi9doL";

//#define RED 23
//#define GREEN 22
//#define BLUE 21
String ipEnd = "7";
IPAddress local_IP(192,168,200,7);
IPAddress gateway(192,168,200,1);
IPAddress subnet(255,255,255,0);

const char *host = "http://192.168.200.1/api/rfid";

#define SS_PIN 5
#define RST_PIN 27

MFRC522 mfrc522(SS_PIN, RST_PIN);  //--> Create MFRC522 instance.

AsyncWebServer webserver(80);  //--> Server on port 80

int readsuccess;
int state = 0; // 0 = continous reading 1 = add tag to text field
byte readcard[4];
char str[32] = "";
String StrUID;
String StrUIDforReg;

//-----------------------------------------------------------------------------------------------SETUP--------------------------------------------------------------------------------------//
void setup() {
  Serial.begin(9600); //--> Initialize serial communications with the PC
  SPI.begin();      //--> Init SPI bus
  mfrc522.PCD_Init(); //--> Init MFRC522 card

  delay(500);

  pinMode(LED_BUILTIN, OUTPUT);
  digitalWrite(LED_BUILTIN, HIGH); //--> Turn off Led On Board

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
    digitalWrite(LED_BUILTIN, LOW);
    delay(250);
    digitalWrite(LED_BUILTIN, HIGH);
    delay(250);
  }
  digitalWrite(LED_BUILTIN, HIGH); //--> Turn off the On Board LED when it is connected to the wifi router.
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
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//-----------------------------------------------------------------------------------------------LOOP---------------------------------------------------------------------------------------//
void loop() {
      readData();
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

//----------------------------------------Procedure for reading and obtaining a UID from a card or keychain---------------------------------------------------------------------------------//

void readData(){
  readsuccess = getid();

  if (readsuccess) {
    digitalWrite(LED_BUILTIN, LOW);

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
  Serial.println(postData);
  Serial.println(httpCode);
  Serial.println(payload);
  http.end();
  delay(1000);
}

    Serial.println(UIDresultSend);

    delay(1000);
    digitalWrite(LED_BUILTIN, HIGH);
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