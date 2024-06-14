#include <WiFi.h>
#include <ESPAsyncWebServer.h>
#include <AsyncTCP.h>
#include <SPI.h>
#include <MFRC522.h>
#include <HTTPClient.h>

#define SS_PIN  5
#define RST_PIN 4
#define LED_BUILTIN 2

MFRC522 rfid(SS_PIN, RST_PIN);
const char* ssid = "Galaxy S10";
const char* password = "123456789";

AsyncWebServer server(80);

String resultD = ""; // Variable to store RFID code
String result = ""; 
int detect = 0;

void setup() {
  Serial.begin(9600);
  pinMode(LED_BUILTIN, OUTPUT);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");

  // Print ESP32 IP address
  Serial.print("ESP32 IP Address: ");
  Serial.println(WiFi.localIP());

  SPI.begin();
  rfid.PCD_Init();

  Serial.println("Tap an RFID/NFC tag on the RFID-RC522 reader");

  server.on("/rfid", HTTP_GET, [](AsyncWebServerRequest *request) {
    // Send the stored RFID code
    request->send(200, "text/plain", resultD);
  });

  server.begin();
}

void loop() {
  if (rfid.PICC_IsNewCardPresent()) { // new tag is available
    if (rfid.PICC_ReadCardSerial()) { // NUID has been read
      MFRC522::PICC_Type piccType = rfid.PICC_GetType(rfid.uid.sak);

      // Convert UID bytes to a string
      result = "";
     
      for (int i = 0; i < rfid.uid.size; i++) {
        if (rfid.uid.uidByte[i] < 0x10) {
          result += "0";
        }
        result += String(rfid.uid.uidByte[i], HEX);
      }

      
      
        
         detect++;
        
         if(executeHTTPRequest(result)){
        resultD = "00000000," + String(detect);
        Serial.println("Result is sent to web :");
        Serial.println(result);
         
        }else
        {
         
          
          resultD = result + "," + String(detect);
          Serial.println("Result is sent to desktop :");
          Serial.println(resultD);
          }      
      
   

    


      // Halt PICC and stop encryption
      rfid.PICC_HaltA();
      rfid.PCD_StopCrypto1();

      // Turn on the LED when a card is detected
      digitalWrite(LED_BUILTIN, HIGH);
      delay(1000); // Wait for a second
      digitalWrite(LED_BUILTIN, LOW); // Turn off the LED
    }
  }
}

boolean executeHTTPRequest(String uidDetected) {
  HTTPClient http;

  // Your URL
  String url = "http://192.168.12.237:8000/uidcard/push/";
  url += uidDetected;

  // Send the GET request
  http.begin(url);

  // Get the response code
  int httpResponseCode = http.GET();
  String payload = http.getString();
 

  // Close connection
  http.end();
  
  return (payload == "published!");
}
