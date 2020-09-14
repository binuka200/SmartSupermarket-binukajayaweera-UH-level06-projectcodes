//NodeMCU,RFID and server code
//This is the arduino code for Self-Checkout system

#include <ESP8266WiFi.h>     //Included Esp library
#include <WiFiClient.h>          //Included Wificlient library
#include <ESP8266WebServer.h>  //Included NodeMCU library
#include <ESP8266HTTPClient.h> //Included NodeMCU Web Connection library
#include <SPI.h>                          //Included SPI library
#include <MFRC522.h>        //included RFID library
#define SS_PIN D2              //RX slave pin is defined
#define RST_PIN D1           //Reset pin is defined

MFRC522 mfrc522(SS_PIN, RST_PIN); // Create MFRC522 instance.

const char *ssid = "E5573";  //ENTER  WIFI SSID
const char *password = "5JFQQDFR"; //ENTER  WIFI PASSWORD
const char *host = "192.168.8.100";   //IP address of server

// String Variables are defined 

String getData ,Link;
String CardID="";

void setup() {
  
  Serial.begin(115200); //Connection to Serial Monitor
  SPI.begin();  // Begin SPI bus
  mfrc522.PCD_Init(); // Init MFRC522 card

  WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
  delay(1000); // Delay by 1 second
  WiFi.mode(WIFI_STA);        //This line hides the viewing of ESP as wifi hotspot
  WiFi.begin(ssid, password);     //Connect to WiFi router
  
  // Print wifi name
  Serial.println(""); 
  Serial.print("Connecting to ");
  Serial.print(ssid);

  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  //If connection successful show IP address in serial monitor
  Serial.println("");
  Serial.println("Connected");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());  //IP address assigned to ESP  
}


void loop() {
  
  //If connection is unsuccessful try reconnecting
  if(WiFi.status() != WL_CONNECTED){
    WiFi.disconnect();
    WiFi.mode(WIFI_STA);
    Serial.print("Reconnecting to ");
    Serial.println(ssid);
    WiFi.begin(ssid, password);
    
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  
    Serial.println("");
    Serial.println("Connected");
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP());  //IP address assigned to ESP
  }
  
    //look for a new RFID card
   if ( ! mfrc522.PICC_IsNewCardPresent()) {
  return;      //go to start of loop if there is no card present
 }
 
 // Select one of the cards
 if ( ! mfrc522.PICC_ReadCardSerial()) {
  return;   //if read card serial(0) returns 1, the UID struct contains the ID of the card.
 }
 
 for (byte i = 0; i < mfrc522.uid.size; i++) {
     CardID += mfrc522.uid.uidByte[i];
 }

  HTTPClient http;    //Declare object of class HTTPClient
  
  //GET Data
  getData = "?CardID=" + CardID;  
  Link = "http://192.168.8.100/loginsystem/postdemo.php" + getData;
  http.begin(Link);
  
  int httpCode = http.GET();            //Send the request
  delay(10);
  
  String payload = http.getString();    //Get the response payload
  Serial.println(httpCode);             //Print HTTP return code
  Serial.println(payload);              //Print request response payload
  Serial.println(CardID);               //Print Card ID
  
  if(payload == "succesful" || payload == "Cardavailable"){
    delay(500);  
  }
  
//Assignment of Variables  
  CardID = "";
  getData = "";
  Link = "";
  http.end();    //Close connection
}
