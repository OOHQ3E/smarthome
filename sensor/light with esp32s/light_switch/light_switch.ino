#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiClient.h>

const char* ssid = "raspberrySmarthome";
const char* password = "huu1vi9doL";
char server[] = "192.168.200.1";

WiFiClient client;

IPAddress local_IP(192,168,200,6);
IPAddress gateway(192,168,200,1);
IPAddress subnet(255,255,255,0);

void setup() {
  pinMode(LED_BUILTIN, OUTPUT);     // Initialize the LED_BUILTIN pin as an output
  Serial.begin(115200);
  delay(1000);

  if(!WiFi.config(local_IP,gateway,subnet)){
    Serial.println("STA failed to configure");
  }

  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid,password);
  Serial.println("\nConnecting");

  while(WiFi.status() != WL_CONNECTED){
    Serial.print(".");
    delay(100);
  }
  
}

void loop() {

client.connect(server,80);

 while (client.available()) {

    String c = client.readString();

    Serial.println(c);

  }
}

