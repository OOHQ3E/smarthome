#include <ESPAsyncWebSrv.h>
#include <WiFi.h>

const char* ssid = "raspberrySmarthome";
const char* password = "huu1vi9doL";

IPAddress local_IP(192,168,200,6);
IPAddress gateway(192,168,200,1);
IPAddress subnet(255,255,255,0);

int state = 0;

AsyncWebServer webserver(80);

void setup(){
  Serial.begin(9600);
  pinMode(LED_BUILTIN, OUTPUT);
  delay(1000);

  if(!WiFi.config(local_IP,gateway,subnet)){
    Serial.println("STA failed to configure");
  }

  WiFi.mode(WIFI_OFF);        
  delay(1000);
  WiFi.mode(WIFI_STA);

  WiFi.begin(ssid,password);
  Serial.println("\nConnecting");

  while(WiFi.status() != WL_CONNECTED){
    Serial.print(".");
    delay(100);
  }
  webserver.on("/status",HTTP_GET, [](AsyncWebServerRequest * request) {
    String temp_res ="{'status':";
    temp_res += state;
    temp_res += "}";

    request->send(200, "text/json", temp_res);

  });
  
  webserver.on("/on",HTTP_GET, [](AsyncWebServerRequest * request) {
    state = 1;
    String temp_res ="{'status':";
    temp_res += state;
    temp_res += "}";
    digitalWrite(LED_BUILTIN,HIGH);
    request->send(200, "text/json", temp_res);

  });

    webserver.on("/off",HTTP_GET, [](AsyncWebServerRequest * request) {
    state = 0;
    String temp_res ="{'status':";
    temp_res += state;
    temp_res += "}";
    digitalWrite(LED_BUILTIN,LOW);
    request->send(200, "text/json", temp_res);

  });
  webserver.begin();
}
void loop(){

}