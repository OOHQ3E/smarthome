#include "DHT.h"
#include <WiFi.h>
#include <HTTPClient.h>
using namespace std;
const char* ssid = "raspberrySmarthome";
const char* password = "huu1vi9doL";

IPAddress local_IP(192,168,200,5);//ip end is 5
IPAddress gateway(192,168,200,1);
IPAddress subnet(255,255,255,0);

#define DHTPIN 23
#define DHTTYPE DHT22

DHT dht(DHTPIN, DHTTYPE);

const char *host = "http://192.168.200.1/api/esp";  // IP/web server address

void setup() {
  Serial.begin(9600); 
  dht.begin();
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
}

void loop() {
  //Declare object of class HTTPClient
  HTTPClient http;
  delay(1000);
  //Prepare data
  String temperature, humidity, postData;
  float h = dht.readHumidity();
  float t = dht.readTemperature();

  humidity = String(h);
  temperature = String(t);
  String ipEnd = "5";
  
  if (isnan(h) || isnan(t)) {
    Serial.println("Failed to read from DHT sensor!");
    return;
  }

  postData =  "ipEnd=" + ipEnd + "&temp=" + temperature + "&hum=" + humidity ;
  http.begin(host);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.POST(postData);
  String payload = http.getString();
  Serial.println(postData);
  Serial.println(httpCode);
  Serial.println(payload);
  http.end();
  delay(9000);
}