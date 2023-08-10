//LATEST

//LIBRARY DEFINING
#include <SoftwareSerial.h>        // Include the SoftwareSerial library for serial communication
#include <ESP8266WiFi.h>           // Include the ESP8266WiFi library for WiFi functionality
#include <LiquidCrystal_I2C.h>     // Include the LiquidCrystal_I2C library for I2C communication with LCD
#include <SPI.h>                   // Include the SPI library for SPI communication
#include <MFRC522.h>               // Include the MFRC522 library for RFID functionality
#include <TinyGPS++.h>             // Include the TinyGPS++ library for GPS functionality
#include <Adafruit_Thermal.h>      // Include the Adafruit_Thermal library for thermal printer functionality
#include <math.h>                  // Include the math library for mathematical functions
#include <ESP8266HTTPClient.h> //provides functionality for making HTTP requests using the ESP8266 board

SoftwareSerial ss(D3, D7);         // Initialize SoftwareSerial object for communication on pins D3 (RX) and D7 (TX)

//DEFINE PINS SA NODEMCU
#define D0 16   // GPIO pin 16
#define D1 5    // GPIO pin 5
#define D2 4    // GPIO pin 4
#define D3 0    // GPIO pin 0
#define D4 2    // GPIO pin 2
#define D5 14   // GPIO pin 14
#define D6 12   // GPIO pin 12
#define D7 13   // GPIO pin 13
#define D8 15   // GPIO pin 15
#define D9 3    // GPIO pin 3
#define D10 1   // GPIO pin 1

// Define the locations
const char* locationNames[] = {
  "Cubao",
  "Col. Bonny Serrano Ave",
  "172 Katipunan Ave ",
  "Escopa II Project 4",
  "213 Katipunan Ave ",
  "333 Katipunan Ave",
  "Katipunan Ave, Diliman, Q.C",
  "868-878 Tandang Sora",
  "Don Mariano Marcos Ave",
  "535 R-7, Matandang Balara, Q.C",
  "17 Don Mariano Marcos Ave ",
  "R-7, Quezon City",
  "R-7, Quezon City",
  "5102 Batasan Rd, Q.C",
  "Bingo, 134 Commonwealth Ave, Q.C",
  "Caritas Health Care, Gen Miguel, Q.C",
  "Don Mariano, Novaliches, Q.C",
  "4 Regalado Hwy, Novaliches, Q.C",
  "168 Regalado Hwy, Novaliches, Q.C",
  "370 Regalado Hwy, Novaliches, Q.C",
  "Fr. Francisco Palau St., Novaliches",
  "Novaliches, Quezon City",
  "Barangay 179, Caloocan",
  "Novaliches, Caloocan",
  "Barangay 181, Caloocan Metro Manila",
  "Bankers Village 2, Caloocan",
  "Loy Store, Barangay 185, Caloocan",
  "Savano Park, Pleasant Hills Subdivision",
  "Radiator Repair Shop, San Jose Del Monte",
  "Gumaoc, San Jose Del Monte, Bulacan",
  "Sevilla resident, San Jose Del Monte",
  "Dr. Maria Soledad, San Jose Del Monte",
  "Church of Christ, 3023, San Jose Del Monte",
  "Zeeia-Tak Carwash, San Jose Del Monte, Bulacan ",
  "Shell, Del Monte Rd, San Jose Del Monte",
  "Magnus Battery, San Jose Del Monte",
  "Cañeda Residence, Minuyan, San Jose Del Monte",
  "Alfamart, San Jose Del Monte, Bulacan",
  "RC-han sa kanto, San Jose Del Monte",
   "Motortrade Yamaha, Sapang Palay, Bulacan",
    "Angel's Pizza, San Jose Del Monte, Bulacan",
     "Santrans Terminal, Sapang Palay, Bulacan",
  "GPS NOT READY"
};
    

const float coordinates[][2] = {
    //CUBAO - SANTRANS (SapangPalay), Bulacan
    {0.000, 0.000},
    {14.617704861265391, 121.05722268882688}, // Cubao
    {14.612783948307168, 121.06269439547007}, // Col. Bonny Serrano Ave - 1km
    {14.615441670282863, 121.07076248033667}, // 172 Katipunan Ave - 2km
    {14.623705319153471, 121.074388826894}, // Escopa II Project 4, Q.C
    {14.633193127150864, 121.07435123358673}, // 213 Katipunan Ave
    {14.641871324783281, 121.0747160140425}, // 333 Katipunan Ave
    {14.651296193252872, 121.07445446604657}, // Katipunan Ave, Diliman, Q.C
    {14.659095740092813, 121.07595765420531}, // 868-878 Tandang Sora
    {14.665808946316535, 121.07141094179377}, // Don Mariano Marcos Ave
    {14.670960261602488, 121.0783491482899}, // 535 R-7, Matandang Balara, Q.C
    {14.678254666138624, 121.08348703388815}, // 17 Don Mariano Marcos Ave
    {14.686553554848055, 121.08698546054815}, // R-7, Quezon City
    {14.695561096639036, 121.08751500142257}, // R-7, Quezon City
    {14.700149339106396, 121.09080695540617}, // 5102 Batasan Rd, Q.C
    {14.704868306229455, 121.08289388801659}, // Bingo, 134 Commonwealth Ave, Q.C
    {14.705206347230927, 121.07517171705199}, // Caritas Health Care, Gen Miguel, Q.C
    {14.706572169096248, 121.06612859481507}, // Don Mariano, Novaliches, Q.C
    {14.713065690313448, 121.06119915792705}, // 4 Regalado Hwy, Novaliches, Q.C
    {14.722049308349712, 121.0612249145138}, // 168 Regalado Hwy, Novaliches, Q.C
    {14.731082255089063, 121.06122410215649}, // 370 Regalado Hwy, Novaliches, Q.C
    {14.735468558268824, 121.06609254522307}, // Fr. Francisco Palau St., Novaliches
    {14.739015913416626, 121.07397275111627}, // Novaliches, Quezon City
    {14.745806769157653, 121.07900457524654}, // Barangay 179, Caloocan
    {14.752264274992406, 121.08481240325946}, // Novaliches, Caloocan
    {14.761337196228741, 121.08664621450406}, // Barangay 181, Caloocan Metro Manila
    {14.767932390092017, 121.08213580858047}, // Bankers Village 2, Caloocan
    {14.774935017098963, 121.07742131748178}, // Loy Store, Barangay 185, Caloocan
    {14.782422583517292, 121.07448131175441}, // Savano Park, Pleasant Hills Subdivision
    {14.791683616331127, 121.0742762322905}, // Radiator Repair Shop, San Jose Del Monte
    {14.798514238657178, 121.06939348724327}, // Gumaoc, San Jose Del Monte, Bulacan
    {14.806719095341755, 121.06851908713071}, // Sevilla resident, San Jose Del Monte
    {14.814591573846252, 121.07349447680001}, // Dr. Maria Soledad, San Jose Del Monte
    {14.822352145352554, 121.07560548943887}, // Church of Christ, 3023, San Jose Del Monte
    {14.830396563082902, 121.07784221610137}, // Zeeia-Tak Carwash, San Jose Del Monte, Bulacan
    {14.838128329134454, 121.07821772538838}, // Shell, Del Monte Rd, San Jose Del Monte
    {14.846545136173715, 121.08068171340024}, // Magnus Battery, San Jose Del Monte
    {14.851651129557688, 121.07581518863014}, // Cañeda Residence, Minuyan, San Jose Del Monte
    {14.858414902885448, 121.07098349929093}, // Alfamart, San Jose Del Monte, Bulacan
    {14.863900146178361, 121.06756291372601}, // RC-han sa kanto, San Jose Del Monte
    {14.860923985439657, 121.05934462531417}, // Motortrade Yamaha, Sapang Palay, Bulacan
    {14.859369622317994, 121.05268264495953}, // Angel's Pizza, San Jose Del Monte, Bulacan
    {14.858495944319948, 121.04804242347849}, // Santrans Terminal, Sapang Palay, Bulacan
    //SANTRANS (SapangPalay), Bulacan - Cubao
    {14.858495944319948, 121.04804242347849}, // Santrans Terminal, Sapang Palay, Bulacan
    {14.859369622317994, 121.05268264495953}, // Angel's Pizza, San Jose Del Monte, Bulacan
    {14.860923985439657, 121.05934462531417}, // Motortrade Yamaha, Sapang Palay, Bulacan
    {14.863900146178361, 121.06756291372601}, // RC-han sa kanto, San Jose Del Monte
    {14.858414902885448, 121.07098349929093}, // Alfamart, San Jose Del Monte, Bulacan
    {14.851651129557688, 121.07581518863014}, // Cañeda Residence, Minuyan, San Jose Del Monte
    {14.846545136173715, 121.08068171340024}, // Magnus Battery, San Jose Del Monte
    {14.838128329134454, 121.07821772538838}, // Shell, Del Monte Rd, San Jose Del Monte
    {14.830396563082902, 121.07784221610137}, // Zeeia-Tak Carwash, San Jose Del Monte, Bulacan
    {14.822352145352554, 121.07560548943887}, // Church of Christ, 3023, San Jose Del Monte
    {14.814591573846252, 121.07349447680001}, // Dr. Maria Soledad, San Jose Del Monte
    {14.806719095341755, 121.06851908713071}, // Sevilla resident, San Jose Del Monte
    {14.798514238657178, 121.06939348724327}, // Gumaoc, San Jose Del Monte, Bulacan
    {14.791683616331127, 121.0742762322905}, // Radiator Repair Shop, San Jose Del Monte
    {14.782422583517292, 121.07448131175441}, // Savano Park, Pleasant Hills Subdivision
    {14.774935017098963, 121.07742131748178}, // Loy Store, Barangay 185, Caloocan
    {14.767932390092017, 121.08213580858047}, // Bankers Village 2, Caloocan
    {14.761337196228741, 121.08664621450406}, // Barangay 181, Caloocan Metro Manila
    {14.752264274992406, 121.08481240325946}, // Novaliches, Caloocan
    {14.745806769157653, 121.07900457524654}, // Barangay 179, Caloocan
    {14.739015913416626, 121.07397275111627}, // Novaliches, Quezon City
    {14.735468558268824, 121.06609254522307}, // Fr. Francisco Palau St., Novaliches
    {14.731082255089063, 121.06122410215649}, // 370 Regalado Hwy, Novaliches, Q.C
    {14.722049308349712, 121.0612249145138}, // 168 Regalado Hwy, Novaliches, Q.C
    {14.713065690313448, 121.06119915792705}, // 4 Regalado Hwy, Novaliches, Q.C
    {14.706572169096248, 121.06612859481507}, // Don Mariano, Novaliches, Q.C
    {14.705206347230927, 121.07517171705199}, // Caritas Health Care, Gen Miguel, Q.C
    {14.704868306229455, 121.08289388801659}, // Bingo, 134 Commonwealth Ave, Q.C
    {14.700149339106396, 121.09080695540617}, // 5102 Batasan Rd, Q.C
    {14.695561096639036, 121.08751500142257}, // R-7, Quezon City
    {14.686553554848055, 121.08698546054815}, // R-7, Quezon City
    {14.678254666138624, 121.08348703388815}, // 17 Don Mariano Marcos Ave
    {14.670960261602488, 121.0783491482899}, // 535 R-7, Matandang Balara, Q.C
    {14.665808946316535, 121.07141094179377}, // Don Mariano Marcos Ave
    {14.659095740092813, 121.07595765420531}, // 868-878 Tandang Sora
    {14.651296193252872, 121.07445446604657}, // Katipunan Ave, Diliman, Q.C
    {14.641871324783281, 121.0747160140425}, // 333 Katipunan Ave
    {14.633193127150864, 121.07435123358673}, // 213 Katipunan Ave
    {14.623705319153471, 121.074388826894}, // Escopa II Project 4, Q.C
    {14.615441670282863, 121.07076248033667}, // 172 Katipunan Ave - 2km
    {14.612783948307168, 121.06269439547007}, // Col. Bonny Serrano Ave - 1km
    {14.617704861265391, 121.05722268882688}, // Cubao
    {0.000, 0.000} // GPS NOT READY
};



//MEASURING DISTANCE
const int MAX_PLACES = 100;

struct Place {
  String name;
  float distance;
};

// Array to store the places and distances Distance (1km each landmarks) (Total of 39km)
Place places[MAX_PLACES] = {
  {"Cubao", 0.0},
  {"Col. Bonny Serrano Ave - 1km",1.0},
  {"172 Katipunan Ave - 2km",2.0},
  {"Escopa II Project 4, Q.C",3.0},
  {"213 Katipunan Ave ",4.0},
  {"333 Katipunan Ave",5.0},
 { "Katipunan Ave, Diliman Q.C",6.0},
  {"868-878 Tandang Sora",7.0},
  {"Don Mariano Marcos Ave",8.0},
  {"535 R-7, Matandang Balara, Q.C",9.0},
  {"17 Don Mariano Marcos Ave",10.0},
  {"R-7, Quezon City ",11.0},
  {"R-7, Quezon City",12.0},
  {"5102 Batasan Rd, Q.C ",13.0},
  {"Bingo, 134 Commonwealth Ave, Q.C",14.0},
  {"Caritas Health Care, Gen Miguel, Q.C",15.0},
  {"Don Mariano, Novaliches, Q.C",16.0},
  {"4 Regalado Hwy, Novaliches, Q.C",17.0},
  {"168 Regalado Hwy, Novaliches, Q.C",18.0},
  {"370 Regalado Hwy, Novaliches, Q.C",19.0},
  {"Fr. Francisco Palau St., Novaliches",20.0},
  {"Novaliches, Quezon City",21.0},
  {"Barangay 179, Caloocan ",22.0},
  {"Novaliches, Caloocan",23.0},
  {"Barangay 181, Caloocan Metro Manila",24.0},
  {"Bankers Village 2, Caloocan",25.0},
  {"Loy Store, Barangay 185, Caloocan",26.0},
  {"Savano Park, Pleasant Hills Subdivision",27.0},
  {"Radiator Repair Shop, San Jose Del Monte",28.0},
  {"Gumaoc, San Jose Del Monte, Bulacan",29.0},
  {"Sevilla resident, San Jose Del Monte",30.0},
  {"Dr. Maria Soledad, San Jose Del Monte",31.0},
  {"Church of Christ, 3023, San Jose Del Monte",32.0},
  {"Zeeia-Tak Carwash, San Jose Del Monte, Bulacan  ",33.0},
  {"Shell, Del Monte Rd, San Jose Del Monte",34.0},
  {"Magnus Battery, San Jose Del Monte",35.0},
  {"Cañeda Residence, Minuyan, San Jose Del Monte",36.0},
  {"Alfamart, San Jose Del Monte, Bulacan",37.0},
  {"RC-han sa kanto, San Jose Del Monte",38.0},
  {"Motortrade Yamaha, Sapang Palay, Bulacan",39.0},
  {"Angel's Pizza, San Jose Del Monte, Bulacan",40.0},
  {"Santrans Terminal, Sapang Palay, Bulacan",40.5},
   
  //SANTRANS (SapangPalay), Bulacan - Cubao			
 {"Santrans Terminal, Sapang Palay, Bulacan",0.0},
 {"Angel's Pizza, San Jose Del Monte, Bulacan",1.0},
 {"Motortrade Yamaha, Sapang Palay, Bulacan",2.0},
 {"RC-han sa kanto, San Jose Del Monte",3.0},
 {"Alfamart, San Jose Del Monte, Bulacan",4.0},
 {"Cañeda Residence, Minuyan, San Jose Del Monte",5.0},
 {"Magnus Battery, San Jose Del Monte",6.0},
 {"Shell, Del Monte Rd, San Jose Del Monte",7.0},
 {"Zeeia-Tak Carwash, San Jose Del Monte, Bulacan  ",8.0},
{"Church of Christ, 3023, San Jose Del Monte",9.0},
{"Dr. Maria Soledad, San Jose Del Monte",10.0},
{"Sevilla resident, San Jose Del Monte",11.0},
{"Gumaoc, San Jose Del Monte, Bulacan",12.0},
{"Radiator Repair Shop, San Jose Del Monte",13.0},
{"Savano Park, Pleasant Hills Subdivision",14.0},
 {"Loy Store, Barangay 185, Caloocan",15.0},
{"Bankers Village 2, Caloocan",16.0},
{"Barangay 181, Caloocan Metro Manila",17.0},
 {"Novaliches, Caloocan",18.0},
 {"Barangay 179, Caloocan ",19.0},
 {"Novaliches, Quezon City",20.0},
 {"Fr. Francisco Palau St., Novaliches",21.0},
 {"370 Regalado Hwy, Novaliches, Q.C",22.0},
 {"168 Regalado Hwy, Novaliches, Q.C",23.0},
 {"4 Regalado Hwy, Novaliches, Q.C",24.0},
{"Don Mariano, Novaliches, Q.C",25.0},
 {"Caritas Health Care, Gen Miguel, Q.C",26.0},
 {"Bingo, 134 Commonwealth Ave, Q.C",27.0},
  {"5102 Batasan Rd, Q.C ",28.0},
  {"R-7, Quezon City",29.0},
 {"R-7, Quezon City ",30.0},
 {"17 Don Mariano Marcos Ave",31.0},
  {"535 R-7, Matandang Balara, Q.C",32.0},
  {"Don Mariano Marcos Ave",33.0},
  {"868-878 Tandang Sora",34.0},
  { "Katipunan Ave, Diliman Q.C",35.0},
  {"333 Katipunan Ave",36.0},
  {"213 Katipunan Ave ",37.0},
 {"Escopa II Project 4, Q.C",38.0},
  {"172 Katipunan Ave - 2km",39.0},
 {"Col. Bonny Serrano Ave - 1km",40.0},
 {"Cubao", 40.5},
};


//ARRAY FOR STORING PASSENGER'S DATA INSIDE NODEMCU
const int MAX_DATA_LENGTH = 50;     // Define a constant integer variable named 'MAX_DATA_LENGTH' and assign it a value of 50. This represents the maximum length of the data.
const int MAX_DATA_SIZE = 100;      // Define a constant integer variable named 'MAX_DATA_SIZE' and assign it a value of 100. This represents the maximum number of data entries.

char data[MAX_DATA_SIZE][MAX_DATA_LENGTH];  // Declare a character array named 'data' with dimensions [MAX_DATA_SIZE][MAX_DATA_LENGTH]. This array will store data entries.
int dataSize = 0;                           // Declare an integer variable named 'dataSize' and initialize it to 0. This variable will track the current number of data entries.
bool exists = false;                        //Unknown usage throughout the code

char IdNum[MAX_DATA_LENGTH];                // Declare a character array named 'IdNum' with a size of 'MAX_DATA_LENGTH'
char Locationpart[MAX_DATA_LENGTH];         // Declare a character array named 'Locationpart' with a size of 'MAX_DATA_LENGTH'

//PRINTER
Adafruit_Thermal printer(&Serial1);   //This line creates an object named printer of type Adafruit_Thermal using the constructor Adafruit_Thermal(&Serial1). The &Serial1 parameter indicates that the printer object is associated with the Serial1 communication interface. This suggests that the printer is connected to the device via the Serial1 port.


TinyGPSPlus gps; //This line creates an object named gps of type TinyGPSPlus using the default constructor.The TinyGPSPlus class is likely part of a library that provides functionality for parsing GPS data.

//LCD
LiquidCrystal_I2C lcd(0x27, 16, 4); //The 16 parameter indicates the number of columns in the LCD display.The 4 parameter indicates the number of rows in the LCD display.

//WIFI CREDENTIALS
const char* ssid = "put_your_server_SSID"; // SSID
const char* password = "put_your_server_pass"; //PASSWORD



const char* postcredentials = "http://192.168.57.184/TripsPH_Dashboard/admin/bus_ticketing_system/bus_ticketing_system.php";  //declares a constant character pointer named postcredentials and assigns it the value. replace this URL with the appropriate IP address for your laptop.
const char* entryprint = "http://192.168.57.184/TripsPH_Dashboard/admin/bus_ticketing_system/entryprint.php";
const char* exitprint = "http://192.168.57.184/TripsPH_Dashboard/admin/bus_ticketing_system/exitprint.php";
const char* entrybalance = "http://192.168.57.184/TripsPH_Dashboard/admin/bus_ticketing_system/entrybalance.php";
const char* exitbalance = "http://192.168.57.184/TripsPH_Dashboard/admin/bus_ticketing_system/exitbalance.php";
const char* transacttype = "http://192.168.57.184/TripsPH_Dashboard/admin/bus_ticketing_system/type.php";

HTTPClient http;
 //creates an instance of the HTTPClient class named http. This class provides methods to send HTTP requests and handle the corresponding responses. By creating an instance of this class, you can use its methods to interact with the server specified by postcredentials.

const int RedLed = 10; // Declare a constant integer variable named 'RedLed' and assign it the value 10. It likely represents a pin number connected to a red LED.

const int GreenLed = D0; // Declare a constant integer variable named 'GreenLed' and assign it the value D0. The actual value of D0 may vary depending on the specific board or framework being used. It likely represents a pin number connected to a green LED.

float latitude, longitude; // Declare two floating-point variables named 'latitude' and 'longitude'. These variables are likely used to store geographical coordinates.

String date_str, time_str; // Declare two String variables named 'date_str' and 'time_str'. They are likely used to store date and time information.

String formattedDateTime; // Declare a String variable named 'formattedDateTime'. It is likely used to store a formatted date and time string.

WiFiServer server(80); // Create a WiFiServer object named 'server' that listens on port 80. It is used for handling incoming connections on the specified port.

String Status_Location = ""; // Declare a String variable named 'Status_Location' and initialize it with an empty string. It is likely used to store status or location information.

MFRC522 rfid(D8, 10); // Create an instance of the MFRC522 class named 'rfid' with the specified pin numbers D8 and 10. It is used for RFID communication.

MFRC522::MIFARE_Key key; // Declare an MFRC522::MIFARE_Key object named 'key'. It is likely used for cryptographic operations related to RFID.

byte nuidPICC[4]; // Declare a byte array named 'nuidPICC' with a size of 4. It is likely used to store RFID card UID (Unique Identifier).

unsigned long timer = 0; // Declare an unsigned long variable named 'timer' and initialize it with the value 0. It is likely used as a timer or timestamp.

int second; // Declare an integer variable named 'second'. It is likely used to store the value of seconds.

int secc = 0; // Declare an integer variable named 'secc' and initialize it with the value 0. It is likely used as a counter or flag.

float Xlat = 0; // Declare a floating-point variable named 'Xlat' and initialize it with the value 0. It is likely used to store a latitude value.

float Xlng = 0; // Declare a floating-point variable named 'Xlng' and initialize it with the value 0. It is likely used to store a longitude value.

bool blinker = true; // Declare a boolean variable named 'blinker' and initialize it with the value true. It is likely used as a flag or control variable.

//MINI 'G' IN THE LCD
byte GPS[] = { B11110, B10000, B10110, B10010, B11110, B00000, B00000, B00000 }; // Declare a byte array named 'GPS' and initialize it with the provided binary values. It likely represents a custom pattern or icon.

//MINI 'S' IN THE LCD
byte SYNC[] = { B11110, B10000, B11110, B00010, B11110, B00000, B00000, B00000 }; // Declare a byte array named 'SYNC' and initialize it with the provided binary values. It likely represents a custom pattern or icon.

unsigned long startTime; // Declare an unsigned long variable named 'startTime'. It is likely used to store a start time or timestamp.

WiFiClient client; // Create a WiFiClient object named 'client'. It is used for making client connections to a server.

  
       
void setup()
{

delay(500); // Pause the program execution for 3000 milliseconds (3 seconds). It is likely used for initialization or as a delay before executing further code.

printer.begin(); // Initialize the Adafruit_Thermal printer.

Wire.begin(D1, D2); // Initialize the I2C communication with the specified pins D1 and D2. It is used for communication with devices connected via I2C.

lcd.init(); // Initialize the LCD display. It prepares the display for further operations.

lcd.backlight(); // Turn on the backlight of the LCD display. It ensures the display is visible.

pinMode(RedLed, OUTPUT); // Set the pin mode of the 'RedLed' pin as OUTPUT. It configures the pin for digital output.

pinMode(GreenLed, OUTPUT); // Set the pin mode of the 'GreenLed' pin as OUTPUT. It configures the pin for digital output.

lcd.createChar(2, GPS); // Create a custom character with the character code 2 using the provided custom pattern 'GPS'. It allows the custom character to be displayed on the LCD.

lcd.createChar(1, SYNC); // Create a custom character with the character code 1 using the provided custom pattern 'SYNC'. It allows the custom character to be displayed on the LCD.

Serial.begin(115200); // Initialize the serial communication with a baud rate of 115200. It is used for communication with the serial monitor or other devices.

Serial1.begin(9600); // Initialize the serial communication on the Serial1 interface with a baud rate of 9600. It is used for communication with external devices connected to the Serial1 port.

    
delay(500); // Pause the program execution for 1000 milliseconds (1 second). It is likely used for initialization or as a delay before executing further code.

ss.begin(9600, SWSERIAL_8N1, D3, D7, false); // Initialize the SoftwareSerial communication on pins D3 (RX) and D7 (TX) with a baud rate of 9600 and using 8N1 configuration. It sets up communication with a device connected via SoftwareSerial.

Serial.println("\n\nSerial Communication has started"); // Print the message "Test" on the serial monitor. It is used for debugging or informational purposes.

WiFi.mode(WIFI_STA); // Set the WiFi mode to Station mode. It configures the ESP8266 module to connect to an existing WiFi network.

WiFi.begin(ssid, password); // Connect to the WiFi network using the provided SSID (network name) and password.

while (WiFi.status() != WL_CONNECTED) { // Enter a loop until the WiFi connection is established.
  delay(500); // Pause the program execution for 1000 milliseconds (1 second).
  Serial.println("Connecting to WiFi..."); // Print the message "Connecting to WiFi..." on the serial monitor. It indicates that the ESP8266 is attempting to connect to the WiFi network.

  lcd.setCursor(0, 0); // Set the cursor position of the LCD display to the first column (0) and the first row (0).
  lcd.print("Connecting to"); // Print the message "Connecting to" on the LCD display.
  lcd.setCursor(0, 1); // Set the cursor position of the LCD display to the first column (0) and the second row (1).
  lcd.print("Wifi..."); // Print the message "Wifi..." on the LCD display.
}

startTime = millis(); // Store the current value of millis() (elapsed milliseconds since the program started) in the 'startTime' variable.

lcd.setCursor(0, 0); // Set the cursor position of the LCD display to the first column (0) and the first row (0).
lcd.print("Booting..."); // Print the message "Booting..." on the LCD display.

SPI.begin(); // Initialize the SPI communication.
rfid.PCD_Init(); // Initialize the RFID reader.

Serial.println(); // Print an empty line on the serial monitor.
// Serial.print(F("Reader: ")); // Print the message "Reader: " on the serial monitor.
// rfid.PCD_DumpVersionToSerial(); // Dump the version information of the RFID reader to the serial monitor.

delay(500); // Pause the program execution for 500 milliseconds (0.5 second).

lcd.clear(); // Clear the content displayed on the LCD display.


Serial.println("WiFi Connected"); // Print the message "WiFi connected" on the serial monitor.
// server.begin(); // Start the WiFi server. It is likely commented out since it is not being used in this code snippet.
Serial.println("Server Started"); // Print the message "Server started" on the serial monitor.
Serial.println(WiFi.localIP()); // Print the local IP address of the ESP8266 on the serial monitor.

printer.setSize('S'); // Set the font size of the printer to small.
printer.setLineHeight(48); // Set the line height of the printer to 24 dots.
printer.boldOff(); // Turn off the bold printing mode.
printer.underlineOff(); // Turn off the underline printing mode.

printer.feed(2); // Feed the paper by 2 lines. It moves the paper up by two lines.
//Serial1.print("Function Test :)"); // Send the string "Function Test :)" via the Serial1 interface.

//printer.feed(2); // Feed the paper by 2 lines.    

//testing of http connection
http.begin(client, postcredentials); // Begin an HTTP connection with the specified client and server URL
String data = ""; // Prepare an empty string for the data to be inserted
int httpResponseCode = http.POST(data); // Send a POST request with the empty data
if (httpResponseCode > 0) {
  Serial.print("HTTP Response code: "); // Print a message indicating the following output is the HTTP response code
  Serial.println(httpResponseCode); // Print the HTTP response code
} else {
  Serial.print("Error code: "); // Print a message indicating the following output is an error code
  Serial.println(httpResponseCode); // Print the error code
}
http.end(); // End the HTTP connection
}

void entryticket(){
   http.begin(client, entryprint); // Begin an HTTP connection with the server
  int httpResponseCode = http.GET(); // Send a GET request and store the response code

  if (httpResponseCode == HTTP_CODE_OK) {
    String response = http.getString(); // Get the response body as a string

    // Print a message to the Serial Monitor
    printer.print(response); 
    Serial.print(response);// Print the response body //printer dapat
  } else {
    Serial.print("Error"); // Print an error message to the Serial Monitor
    Serial.println(httpResponseCode); // Print the HTTP response code
  }

  http.end(); // End the HTTP connection
}

void typetransact(){
   http.begin(client, transacttype); // Begin an HTTP connection with the server
  int httpResponseCode = http.GET(); // Send a GET request and store the response code

  if (httpResponseCode == HTTP_CODE_OK) {
    String response = http.getString(); // Get the response body as a string

    // Print a message to the Serial Monitor
    lcd.print(response);
    printer.print(response); 
     Serial.print(response);// Print the response body //printer dapat
  } else {
    Serial.print("Error"); // Print an error message to the Serial Monitor
    Serial.println(httpResponseCode); // Print the HTTP response code
    
  }

  http.end(); // End the HTTP connection
}

void exitticket(){
   http.begin(client, exitprint); // Begin an HTTP connection with the server
  int httpResponseCode = http.GET(); // Send a GET request and store the response code

  if (httpResponseCode == HTTP_CODE_OK) {
    String response = http.getString(); // Get the response body as a string

    // Print a message to the Serial Monitor
    printer.print(response);
     Serial.print(response); // Print the response body //printer dapat
  } else {
    Serial.print("Error"); // Print an error message to the Serial Monitor
    Serial.println(httpResponseCode); // Print the HTTP response code
    
  }

  http.end(); // End the HTTP connection
}

void entrymoney(){
   http.begin(client, entrybalance); // Begin an HTTP connection with the server
  int httpResponseCode = http.GET(); // Send a GET request and store the response code

  if (httpResponseCode == HTTP_CODE_OK) {
    String response = http.getString(); // Get the response body as a string

    // Print a message to the Serial Monitor
    lcd.print(response); // Print the response body
    delay(2000);
    printer.print(response);
     Serial.print(response); // Print the response body //printer dapat
  } else {
    Serial.print("Error"); // Print an error message to the Serial Monitor
    Serial.println(httpResponseCode); // Print the HTTP response code
  }

  http.end(); // End the HTTP connection
}

void exitmoney(){
   http.begin(client, exitbalance); // Begin an HTTP connection with the server
  int httpResponseCode = http.GET(); // Send a GET request and store the response code

  if (httpResponseCode == HTTP_CODE_OK) {
    String response = http.getString(); // Get the response body as a string

    // Print a message to the Serial Monitor
    lcd.print(response); // Print the response body
    delay(2000);
    printer.print(response);
     Serial.print(response); //printer dapat
  } else {
    Serial.print("Error"); // Print an error message to the Serial Monitor
    Serial.println(httpResponseCode); // Print the HTTP response code
  }

  http.end(); // End the HTTP connection
}

void loop() {

  digitalWrite(RedLed, HIGH); // Turn on the red LED
  digitalWrite(GreenLed, LOW); // Turn off the green LED
  constantCheckSerial(); // Perform some constant serial checks

  lcd.clear();
  displayStatusLCD(); // Update the status on the LCD display

  lcd.setCursor(4, 1);
  lcd.print("Scan Your"); // Display a message on the LCD
  lcd.setCursor(-1, 2);
  lcd.print("Card Below ");

  delay(1000);
  
  lcd.clear();

   //lcd.setCursor(2, -1);
  //lcd.print("Current"); // Display a message on the LCD
  lcd.setCursor(2, 2);
  //lcd.print("Location: ");
  lcd.print(findClosestLocation(latitude, longitude));
  delay(1000);

  if (!rfid.PICC_IsNewCardPresent()) {
    return; // If no new card is detected, exit the loop and return
  }

  if (!rfid.PICC_ReadCardSerial()) {
    return; // If card reading fails, exit the loop and return
  }

  if (isDifferentCard()) {
    Serial.println(F("A new card has been detected.")); // Print a message to the Serial Monitor

    for (byte i = 0; i < 4; i++) {
      nuidPICC[i] = rfid.uid.uidByte[i]; // Store the unique identifier of the new card
    }

delay(1000);

    Serial.println(F("Card UID: ")); // Print a message to the Serial Monitor
    //Serial.print(F(""));
    Serial.println(getHex(rfid.uid.uidByte, rfid.uid.size)); // Convert and print the unique identifier in hexadecimal format
  } else {
    Serial.println(F("Card UID: ")); // Print a message to the Serial Monitor
  }

  String sampledData = (getHex(rfid.uid.uidByte, rfid.uid.size)); // Convert the unique identifier to a hexadecimal string
  String sampleLocation = sampledData + ";" + findClosestLocation(latitude, longitude); // Combine the unique identifier with the closest location
  const char* sampleData = sampleLocation.c_str(); // Convert the sample location to a C-string
  saveData(sampleData); // Save the sample data

/*
  //RETRIEVE?
  http.begin(client, postcredentials); // Begin an HTTP connection with the server
  int httpResponseCode = http.GET(); // Send a GET request and store the response code

  if (httpResponseCode == HTTP_CODE_OK) {
    String response = http.getString(); // Get the response body as a string

    Serial.print("?"); // Print a message to the Serial Monitor
    printer.println(response); // Print the response body
  } else {
    Serial.print("Error accessing server. HTTP response code: "); // Print an error message to the Serial Monitor
    Serial.println(httpResponseCode); // Print the HTTP response code
  }

  http.end(); // End the HTTP connection
*/
  (exists == 0) ? receiptEntry() : receiptExit(); // Perform either receiptEntry() or receiptExit() based on the value of the "exists" variable
  delay(500);
}


String getHex(byte *buffer, byte bufferSize) {
  String result;
  for (byte i = 0; i < bufferSize; i++) {
    result += (buffer[i] < 0x10 ? " 0" : " ") + String(buffer[i], HEX); // Convert each byte of the buffer to a hexadecimal string
  }
  return result;
  delay(500);
}

bool isDifferentCard() {
  for (byte i = 0; i < 4; i++) {
    if (rfid.uid.uidByte[i] != nuidPICC[i]) {
      return true; // If any byte of the new card's unique identifier is different from the stored identifier, return true
    }
  }
  return false; // If all bytes of the new card's unique identifier are the same as the stored identifier, return false
}

void printTicketDetails(const char* label, const char* value) {
  printer.boldOn(); // Turn on bold font style for printing
  printer.print(label); // Print the label
  printer.boldOff(); // Turn off bold font style
  printer.setLineHeight(48); // Set the line height for printing
  printer.println(value); // Print the value
  printer.setLineHeight(40); // Reset the line height
}

//calculates the distance between two geographical coordinates using the haversine formula
float calculateDistance(float lat1, float lon1, float lat2, float lon2) {
  float radius = 6371.0; // Earth's radius in kilometers

  // Convert degrees to radians
  float lat1Rad = radians(lat1);
  float lon1Rad = radians(lon1);
  float lat2Rad = radians(lat2);
  float lon2Rad = radians(lon2);

  // Haversine formula
  float dlat = lat2Rad - lat1Rad;
  float dlon = lon2Rad - lon1Rad;
  float a = pow(sin(dlat / 2), 2) + cos(lat1Rad) * cos(lat2Rad) * pow(sin(dlon / 2), 2);
  float c = 2 * atan2(sqrt(a), sqrt(1 - a));
  float distance = radius * c;

  return distance;
}

//Closest Location
const char* findClosestLocation(float testLatitude, float testLongitude) {
  int closestIndex = 0; // Index of the closest location
  float closestDistance = calculateDistance(testLatitude, testLongitude, coordinates[0][0], coordinates[0][1]); // Calculate the distance between the test coordinates and the first location

  // Iterate through the locations to find the closest one
  for (int i = 1; i < sizeof(locationNames) / sizeof(locationNames[0]); i++) {
    float distance = calculateDistance(testLatitude, testLongitude, coordinates[i][0], coordinates[i][1]); // Calculate the distance between the test coordinates and the current location

    // Check if the current location is closer than the previously found closest location
    if (distance < closestDistance) {
      closestIndex = i; // Update the index of the closest location
      closestDistance = distance; // Update the closest distance
    }
  }

  return locationNames[closestIndex]; // Return the name of the closest location
}

void constantCheckSerial() {
    // WHILE LOOP TO CHECK THE LATEST VALUES
    while (ss.available() > 0) { // Check if there is data available to read from the serial input
        if (gps.encode(ss.read())) { // Read a character from the serial input and attempt to parse it as a GPS message
            if (gps.location.isValid()) { // Check if the GPS location information is valid
                latitude = gps.location.lat(); // Retrieve the latitude value from the GPS location and assign it to the 'latitude' variable
                longitude = gps.location.lng(); // Retrieve the longitude value from the GPS location and assign it to the 'longitude' variable
            }
            if (gps.date.isValid()) { // Check if the GPS date information is valid
                int month = gps.date.month(); // Retrieve the month value from the GPS date and assign it to the 'month' variable
                int day = gps.date.day(); // Retrieve the day value from the GPS date and assign it to the 'day' variable
                int hour = (gps.time.hour() + 8) % 24; // Retrieve the hour value from the GPS time, adjust it for the time zone (add 8 hours), and calculate the remainder when divided by 24. Assign the result to the 'hour' variable
                int year = gps.date.year() % 100; // Retrieve the year value from the GPS date and calculate the remainder when divided by 100. Assign the result to the 'year' variable

                String monthStr = (month < 10) ? "0" + String(month) : String(month); // Convert the month value to a string with leading zero if it is less than 10. Assign the result to the 'monthStr' variable
                String dayStr = (day < 10) ? "0" + String(day) : String(day); // Convert the day value to a string with leading zero if it is less than 10. Assign the result to the 'dayStr' variable
                date_str = monthStr + "/" + dayStr + "/" + String(year); // Concatenate the month, day, and year values to form a date string in the format "MM/DD/YY". Assign the result to the 'date_str' variable
            }

            if (gps.time.isValid()) { // Check if the GPS time information is valid
                int hour = (gps.time.hour() + 8) % 24; // Retrieve the hour value from the GPS time, adjust it for the time zone (add 8 hours), and calculate the remainder when divided by 24. Assign the result to the 'hour' variable
                int minute = gps.time.minute(); // Retrieve the minute value from the GPS time and assign it to the 'minute' variable
                int second = gps.time.second(); // Retrieve the second value from the GPS time and assign it to the 'second' variable

                if (minute > 59) { // Check if the minute value is greater than 59
                    minute -= 60; // Subtract 60 from the minute value
                    hour += 1; // Increment the hour value by 1
                }

                String am_pm = (hour < 12) ? "AM" : "PM"; // Determine whether it is AM or PM based on the hour value
                hour = (hour > 12) ? hour - 12 : hour; // Convert the hour value to 12-hour format if it is greater than 12
                hour = (hour == 0) ? 12 : hour; // If the hour value is 0, set it to 12

                String hourStr = (hour < 10) ? "0" + String(hour) : String(hour); // Convert the hour value to a string with leading zero if it is less than 10. Assign the result to the 'hourStr' variable
                String minuteStr = (minute < 10) ? "0" + String(minute) : String(minute); // Convert the minute value to a string with leading zero if it is less than 10. Assign the result to the 'minuteStr' variable
                String secondStr = (second < 10) ? "0" + String(second) : String(second); // Convert the second value to a string with leading zero if it is less than 10. Assign the result to the 'secondStr' variable

                time_str = hourStr + ":" + minuteStr + am_pm; // Concatenate the hour, minute, and AM/PM indicator to form a time string in the format "HH:MM AM/PM". Assign the result to the 'time_str' variable
            }
        }
    }
}

void displayStatusLCD()
{
  // Check if GPS is available and time is synced
  second = gps.time.second();  // Get the current second from the GPS time
  
  // Check if enough time has passed to update the LCD display
  if (millis() > timer + 2300) {
    timer = millis();  // Reset the timer
    
    lcd.setCursor(0, 0);  // Set the cursor to the first column of the first row
    lcd.print(blinker ? " " : ".");  // Print a blinking dot or space based on 'blinker' state
    blinker = !blinker;  // Toggle the 'blinker' state
    
    // Check if the current second has changed
    if (secc != second) {
      lcd.setCursor(15, 0);  // Set the cursor to the last column of the first row
      lcd.write(1);  // Display a custom character (presumably indicating second)
      secc = second;  // Update the stored second value
    } else {
      lcd.setCursor(15, 0);
      lcd.print(" ");  // Print a space if the second hasn't changed
    }
    
    // Check if latitude or longitude has changed
    if (latitude != Xlat || longitude != Xlng) {
      lcd.setCursor(14, 0);  // Set the cursor to the second-to-last column of the first row
      lcd.write(2);  // Display a custom character (presumably indicating location change)
      Xlat = latitude;  // Update the stored latitude value
      Xlng = longitude;  // Update the stored longitude value
    } else {
      lcd.setCursor(14, 0);
      lcd.print(" ");  // Print a space if the location hasn't changed
    }
  }
}


void saveData(const char* newData)
{
  // Print the received data to the Serial monitor
  Serial.printf("Data Received: %s\n", newData);

  // Find the position of the semicolon in the received data
  const char* semicolonPos = strchr(newData, ';');
  if (semicolonPos == nullptr) {
    // Invalid input format, print error and return
    Serial.println("Invalid input format.");
    return;
  }

  // Calculate the length of the data before and after the semicolon
  size_t beforeSemicolonLength = semicolonPos - newData;
  size_t afterSemicolonLength = strlen(semicolonPos + 1);

  // Extract the data before the semicolon into the global variable IdNum
  strncpy(IdNum, newData, beforeSemicolonLength);
  IdNum[beforeSemicolonLength] = '\0';

  // Extract the data after the semicolon into the global variable Locationpart
  strcpy(Locationpart, semicolonPos + 1);

  for (int i = 0; i < dataSize; i++) {
    if (strncmp(data[i], newData, beforeSemicolonLength) == 0) {
      // Data already exists in the array, remove it
      for (int j = i; j < dataSize - 1; j++) {
        strcpy(data[j], data[j + 1]);
      }
      dataSize--;
      exists = true;
      Serial.println("Data removed from the array.");
      Serial.println("============");
      Serial.println("Data: Review: ");
      for (int k = 0; k < dataSize; k++) {
        Serial.println(data[k]);
      }
      Serial.println("============");

      // Print the extracted data
      //Serial.printf("Card UID: %s\n", IdNum);
      //Serial.printf("Location: %s\n", Locationpart);

      // Return to prevent adding the newData again
      return;
    }
  }

  // Data does not exist in the array, add it
  if (dataSize >= MAX_DATA_SIZE) {
    Serial.println("Data array is full.");
    return;
  }

  exists = false;
  strcpy(data[dataSize], newData);
  dataSize++;
  Serial.println("Data added to the array.");
  Serial.println("============");
  //Serial.println("Data Array Contents:");
  for (int i = 0; i < dataSize; i++) {
    Serial.println(data[i]);
  }
  Serial.println("============");
}

// This function calculates the distance in kilometers between two places.
float calculateKM(String place1, String place2) {
  // Find the distances for the given places
  float distance = -1.0; // Initialize the distance variable to -1.0

  int startIndex = -1; // Initialize the start index variable to -1
  int endIndex = -1; // Initialize the end index variable to -1

  // Check if either place1 or place2 is "GPS NOT READY", or if place1 is the same as place2
  if (place1 == "GPS NOT READY" || place2 == "GPS NOT READY" || place1 == place2) {
    distance = 0; // Set the distance to 0
    return distance; // Return the distance
  }

  // Iterate through the places array
  for (int i = 0; i < MAX_PLACES; i++) {
    // Check if the name of the current place matches place1
    if (places[i].name.equals(place1)) {
      startIndex = i; // Set the start index to the current index
    }
    // Check if the name of the current place matches place2
    else if (places[i].name.equals(place2)) {
      endIndex = i; // Set the end index to the current index
    }

    // If both the start index and end index are found
    if (startIndex != -1 && endIndex != -1) {
      distance = 0.0; // Initialize the distance to 0.0
      int increment = 1; // Initialize the increment variable to 1

      // If the start index is greater than the end index, set the increment to -1
      if (startIndex > endIndex) {
        increment = -1;
      }

      // Iterate through the places array from the start index to the end index
      for (int j = startIndex; j != endIndex; j += increment) {
        distance += places[j].distance; // Add the distance of each place to the total distance
      }
      break; // Exit the loop
    }
  }

  return distance; // Return the calculated distance
}

//TO COMPUTE THE FARE
float calculateCost(int totalKM) {
  float baseCost = 58.5; // Base cost for distances less than or equal to 13km
  float additionalCostPerKm = 2.25; // Additional cost per kilometer for distances greater than 13km
    
  
/* if(totalKM==0)
    {
    baseCost=0;
    return baseCost;    
        }*/
  if (totalKM <= 26) {
    return baseCost;
  } else {
    float additionalDistance = totalKM - 26;
    float additionalCost = additionalDistance * additionalCostPerKm;
    return baseCost + additionalCost;
  }
}
    
    
void receiptEntry()
{
    digitalWrite(RedLed, LOW);
    digitalWrite(GreenLed, HIGH);

//MYSQL RETRIEVE

//DISPLAYING TO LCD
//FORMATTING
formattedDateTime = date_str + "," + time_str;
const char* closestLocation = findClosestLocation(latitude, longitude);  
//Serial.println(formattedDateTime);   
//Serial.println(closestLocation);    
lcd.clear();
lcd.setCursor(-4, 3);
//lcd.print(formattedDateTime);
lcd.setCursor(-4, 2);    
lcd.print(closestLocation);
lcd.setCursor(0, 0);
//lcd.print("Entry");
lcd.setCursor(0, 1);
delay(1000);
lcd.clear();

//MYSQL SEND
http.begin(client,postcredentials);
http.addHeader("Content-Type", "application/x-www-form-urlencoded");
     
String complete = "Not Yet";
String umid = getHex(rfid.uid.uidByte, rfid.uid.size);
String location1 = closestLocation;
String timeentry = formattedDateTime;
String timeexit = "";
String location2 = "";
String fare = "";
String current_balance = "";
//String total_balance = "";
String km_travel = "";

String data = "&complete=" + complete + "&umid=" + umid + "&timeentry=" + timeentry + "&location1=" + location1 + "&timeexit=" + timeexit + "&location2=" + location2 + "&fare=" + fare + "&current_balance=" + current_balance + "&km_travel=" + km_travel;


  int httpResponseCode = http.POST(data);

  if (httpResponseCode > 0) {
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);
  } else {
    Serial.print("Error code: ");
    Serial.println(httpResponseCode);
  }
    http.end();    
    
    //receiptentry

entrymoney();
delay(1000);
lcd.clear();
typetransact();
entryticket();

/*
//PRINTER- ENTRY
   printer.boldOn();
   printer.println("TEAM TRIPSPH");
   printer.println("EARIST");
   printer.boldOn();
   printer.feed(1);

  printTicketDetails("Card UID: ",(getHex(rfid.uid.uidByte, rfid.uid.size)).c_str());
  printer.println("Control Number: ");
  printTicketDetails("Entry Location: ", closestLocation);
  printTicketDetails("Entry Time: ", time_str.c_str());
  printTicketDetails("Date: ", date_str.c_str() );
  
  printer.feed(2);

  printer.boldOn();
  printer.println("Starting Balance: ");
 printer.boldOff();
 printer.feed();

  printer.println("Enjoy your");
  printer.println("Journey!"); 

  printer.feed(1);

  printer.println("Mabuhay!"); 

  printer.feed(2);

lcd.clear();
*/

    //Recheck
rfid.PICC_HaltA();
rfid.PCD_StopCrypto1();
return;

}

void receiptExit()
{

  digitalWrite(RedLed, LOW);
    digitalWrite(GreenLed, HIGH);
formattedDateTime = date_str + "," + time_str;
const char* closestLocation = findClosestLocation(latitude, longitude);  
  float distanceCost = calculateCost(calculateKM(Locationpart,closestLocation)); 
Serial.printf("%s - %s\n",Locationpart,closestLocation);   
//Serial.println(formattedDateTime);   
//Serial.println(closestLocation);    
lcd.clear();
lcd.setCursor(-4, 3);
//lcd.print(formattedDateTime);
lcd.setCursor(-4, 2);
lcd.print(closestLocation);
delay(1000);
lcd.clear();
    
//lcd.print(String(latitude, 3)); ???
//lcd.print(","); ???
//lcd.print(String(longitude, 3)); ???
lcd.setCursor(0, 0);
//lcd.print("Exit");
    
//lcd.print(getHex(rfid.uid.uidByte, rfid.uid.size));
lcd.setCursor(0, 1);
//lcd.print(distanceCost);
    
    
 //MYSQL SEND
http.begin(client,postcredentials);
http.addHeader("Content-Type", "application/x-www-form-urlencoded");
     
String complete = "Completed";
String umid = getHex(rfid.uid.uidByte, rfid.uid.size);
String location1 = "";
String timeentry = "";
String timeexit = formattedDateTime;
String location2 = closestLocation;
String km_travel = String(calculateKM(Locationpart,closestLocation));
String fare = String(distanceCost);

String current_balance = "";

String data = "&complete=" +(complete) + "&umid=" + (umid) +  "&timeentry=" + (timeentry) +"&location1=" +(location1) + "&timeexit=" +(timeexit) + "&location2=" + (location2) + "&fare=" + (fare) + "&current_balance=" +(current_balance) + "&km_travel=" +(km_travel);

  int httpResponseCode = http.POST(data);

  if (httpResponseCode > 0) {
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);
  } else {
    Serial.print("Error code: ");
    Serial.println(httpResponseCode);
  }    
    http.end();       

//receiptexit
exitmoney();
delay(1000);
lcd.clear();
typetransact();
exitticket();
   /* 
//PRINTER - EXIT 
  printer.println("TEAM TRIPSPH");
    
  printTicketDetails("Card UID: ",(getHex(rfid.uid.uidByte, rfid.uid.size)).c_str());
  printer.println("Control No: ");
  printTicketDetails("Destination: ", closestLocation);
  printTicketDetails("Status: ", closestLocation);
  printTicketDetails("Departure Time: ", time_str.c_str());
  printTicketDetails("Date: ", date_str.c_str() );
  

  printer.feed(1);

  // Print the fare amount
  printer.boldOn();
   
  printer.print("Fare: ");
  printer.println(distanceCost);
  printer.println("Balalance Remaining: ");
  printer.boldOff();

  printer.feed(1);

  // Print the footer
  printer.println("Thank you for choosing");
  printer.println("our service!");  
  printer.println("Please Come Again!");
//  printer.feed(2);  
printer.println("");  
  // Feed paper and cut the receipt
  printer.feed(3);

lcd.clear();
*/
    //FROM THE START
rfid.PICC_HaltA();
rfid.PCD_StopCrypto1();
return;

}

