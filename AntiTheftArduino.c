//Anti-Theft Arduino Code

#include <SPI.h> //SPI library
#include <MFRC522.h> //RFID library
#include <Servo.h> //Servo library
#define SS_PIN 10 //SDA pin of RFID reader
#define RST_PIN 9 //reset pin of RFID reader
#define BUZZER 2 //buzzer pin

MFRC522 mfrc522(SS_PIN, RST_PIN);   // Create MFRC522 instance.

Servo myServo; //define servo name
int enA = 5; //define pin 5 to enableA of L298N module
int in1 = 4; //define pin 4 to in1 of L298N module
int in2 = 6; //define pin 6 to in2 of L298N module

void setup() 
{
  Serial.begin(9600);   // Initiate a serial communication
  SPI.begin();      // Initiate  SPI bus
  mfrc522.PCD_Init();   // Initiate MFRC522
  myServo.attach(3); //servo pin
  myServo.write(0); //servo start position
  pinMode(BUZZER, OUTPUT); // Set buzzer as output
  noTone(BUZZER);  //set buzzer to no tune
  Serial.println("Put your card to the reader..."); //Print this on serial monitor
  Serial.println();
  pinMode(enA, OUTPUT); // Set enableA of L298N as output
  pinMode(in1, OUTPUT); // Set in1 of L298N as output
  pinMode(in2, OUTPUT); // Set in2 of L298N as output
}

void loop() 

{
  // Look for new cards
  if ( ! mfrc522.PICC_IsNewCardPresent()) 
  {
    return;
  }
  // Select one of the cards
  if ( ! mfrc522.PICC_ReadCardSerial()) 
  {
    return;
  }
  
  //Show UID on serial monitor
  Serial.print("UID tag :"); //Print this on serial monitor
  String content= ""; //Assignment of string Variable
  byte letter; //Assignment of byte Variable
  
  //Obtain UID from the card using for loop
  for (byte i = 0; i < mfrc522.uid.size; i++) 
  {
     Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
     Serial.print(mfrc522.uid.uidByte[i], HEX);
     content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
     content.concat(String(mfrc522.uid.uidByte[i], HEX));
  }
  Serial.println();
  Serial.print("Message : "); //Print this on serial monitor
  content.toUpperCase();
  if (content.substring(1) == "59 B5 68 B9" || content.substring(1) == "66 29 B2 1F") //change here the UID of the card/cards that admin wants to give access
  {
    Serial.println("Authorized access"); //Print this on serial monitor
    Serial.println();
    delay(500); //Delay by 0.5 seconds
    tone(BUZZER, 400); //set buzzer to tune 4
    delay(500); //Delay by 0.5 seconds
    noTone(BUZZER); //set buzzer to no tune
    
    // turn on motor B
    digitalWrite(in1, HIGH);
    digitalWrite(in2, LOW);
    
  // set speed to 200 out of possible range 0~255
    analogWrite(enA, 200);
    
    myServo.write(90);  //rotate servo motor by 90 degrees
  
    delay(5000); //Delay by 5 seconds

  // now turn off motors
    digitalWrite(in1, LOW);
    digitalWrite(in2, LOW); 
    
    myServo.write(0); //rotate servo motor back to original position
  }
  
  //If invalid RFID card or product is noticed
 else   {
    Serial.println(" Access denied"); //Print this on serial monitor
    tone(BUZZER, 300); //set buzzer to tune 3
    delay(1000); //Delay by 1 seconds
    noTone(BUZZER); //set buzzer to no tune
  }
}
