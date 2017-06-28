// LED to show booking
//ef46d7dc-5971-4b79-a782-f15a45feae28

#include<WiFi.h>
WiFiClient client;

#define echoPin 7 // Echo Pin
#define trigPin 8 // Trigger Pin
#define LEDPin 13 // Onboard LED

//Home WiFi
//char* ssid = "theBIGbox";
//char* password = "98765432";
//Incubator WiFi
//char* ssid = "Incubator";
//char* password = "Incubator#2013";
//School WiFi
char* ssid = "strathmore";
char* password = "5trathm0re";
//Mark
//char* ssid = "OnePlus3";
//char* password = "12345678";

//Home
//char* host = "192.168.43.104";
//Incubator
//char* host = "172.16.40.165";
//School
char* host = "10.51.7.42";
int maximumRange = 200; // Maximum range needed
int minimumRange = 0; // Minimum range needed
long duration, distance; // Duration used to calculate distance
int availability;

void setup() {
 Serial.begin (9600);
 pinMode(trigPin, OUTPUT);
 pinMode(echoPin, INPUT);
 pinMode(LEDPin, OUTPUT); // Use LED indicator (if required)

 Serial.println();
 Serial.print("Connecting to ");
 Serial.println(ssid);
 WiFi.begin(ssid, password);
 
  while(WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
  }
  
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
 
}

void loop() {
/* The following trigPin/echoPin cycle is used to determine the
 distance of the nearest object by bouncing soundwaves off of it. */ 
 digitalWrite(trigPin, LOW); 
 delayMicroseconds(2); 

 digitalWrite(trigPin, HIGH);
 delayMicroseconds(10); 
 
 digitalWrite(trigPin, LOW);
 duration = pulseIn(echoPin, HIGH);
 
 //Calculate the distance (in cm) based on the speed of sound.
 distance = duration/58.2;
 
   if (distance <= minimumRange){
   /* Send a negative number to computer and Turn LED ON 
   to indicate "out of range" */
   Serial.println("Out of range");
   digitalWrite(LEDPin, HIGH); 
   }
   else {
   /* Send the distance to the computer using Serial protocol, and
   turn LED OFF to indicate successful reading. */
    if(distance > 50){
      allocateSensors(3, 1);
      Serial.println("Delaying");
      delay(10000);
    }else if(distance < 51){
      allocateSensors(3, 0);
    }
   
   digitalWrite(LEDPin, LOW);
   }
    
 //Delay 50ms before next reading.
 delay(2000);
}

void allocateSensors(int spot, int availability){
  Serial.print("Connecting to ");
   Serial.println(host);

   const int httpPort = 80;
    if(!client.connect(host, httpPort)){
      Serial.println("connection failed");
    }else{
      Serial.println(availability);
      client.print("GET /finalparking/dynamic_data/Save.php?");
      client.print("position=");
      client.print(spot);
      client.print("&&availability=");
      client.print(availability);
      client.println(" HTTP/1.1");
      client.println("Host: 192.168.43.104");
      client.println("Connection: close");
      client.println(); // Empty line
      client.stop();
      delay(1000);
    }
    
  
}

