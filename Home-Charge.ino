//Menginport Library yang dibutuhkan
#include <ESP8266WiFi.h>
#include <SoftwareSerial.h>
#include <ArduinoJson.h>
#include <ESP8266HTTPClient.h>
#include <Servo.h>
#include <Adafruit_Fingerprint.h>
Servo myServo;


//Program default untuk fingerprint
#if (defined(__AVR__) || defined(ESP8266)) && !defined(__AVR_ATmega2560__)
// For UNO and others without hardware serial, we must use software serial...
// pin #2 is IN from sensor (GREEN wire)
// pin #3 is OUT from arduino  (WHITE wire)
// Set up the serial port to use softwareserial..
SoftwareSerial mySerial(5, 4);// TX , RX (berguna untuk menghubungkan ke fingerprint)

#else
// On Leonardo/M0/etc, others with hardware serial, use hardware serial!
// #0 is green wire, #1 is white
#define mySerial Serial1

#endif


Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);
//akhir dari setup fingerprint

//connect ke wifi
const char* ssid = "nextjack";
const char* password = "dwl686168";

String host = "risetkanta.com";//masukin nama domain

const int idMachine = 1;//memberi tahu id machine yang di kelola oleh arduino

//mendeclair segala variabel yang dibutuhkan
int value = 0;
int penguncian = 0;
String nilai = "";
int firstVal, SecondVal;

//Memasukan pin untuk sensor dan led
int obstaclePin = 16;
int ledIndicator =  2;


//fungsi untuk mengirimkan database
void kirimdb(int idMachine)
{
  //program untuk mengecek koneksi ke wifi
  Serial.print("connecting to ");
  Serial.println(host);
  // Use WiFiClient class to create TCP connections
  WiFiClient client;
  const int httpPort = 80;

  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }
  else
  {
    //program untuk mengirimkan http request
    client.print("GET http://" + host + "/projects/dave/charging_station/updateMachine.php?idM=");
    client.print(idMachine);
    client.println("");
    client.println( " HTTP/1.1");
    client.println( "Host: 192.168.43.83" );
    client.println( "Content-Type: application/x-www-form-urlencoded" );
    client.println( "Connection: close" );
    client.println();
    client.println();
    client.stop();
  }
  delay(3000);// delay 3 detik
}

//Fungsi untuk memisahkan respon yang dikirimkan dari database
String getValue(String data, char separator, int index)
{
  int found = 0;
  int strIndex[] = {0, 0};
  int maxIndex = data.length();
  for (int i = 0; i <= maxIndex && found <= index; i++)
  {
    if (data.charAt(i) == separator || i == maxIndex)
    {
      found++;
      strIndex[0] = strIndex[1] + 1;
      strIndex[1] = (i == maxIndex) ? i + 1 : i;
    }
  }
  String ketemu = found > index ? data.substring(strIndex[0], strIndex[1]) : "";
  return ketemu;
}

void setup()
{
  Serial.begin(9600);
  delay(10);

  // We start by connecting to a WiFi network

  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  /* Explicitly set the ESP8266 to be a WiFi-client, otherwise, it by default,
     would try to act as both a client and an access-point and could cause
     network-issues with your other WiFi-devices on your WiFi-network. */
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  pinMode(obstaclePin, INPUT);
  pinMode(ledIndicator, OUTPUT);
  myServo.attach(0);
  myServo.write(60);
  finger.begin(57600);//serial untuk komunikasi fingerprint
  delay(5);

  //program default fingerprint
  if (finger.verifyPassword()) {
    Serial.println("Found fingerprint sensor!");
  } else {
    Serial.println("Did not find fingerprint sensor :(");
    while (1) {
      delay(1);
    }
  }

  Serial.println(F("Reading sensor parameters"));
  finger.getParameters();
  Serial.print(F("Status: 0x")); Serial.println(finger.status_reg, HEX);
  Serial.print(F("Sys ID: 0x")); Serial.println(finger.system_id, HEX);
  Serial.print(F("Capacity: ")); Serial.println(finger.capacity);
  Serial.print(F("Security level: ")); Serial.println(finger.security_level);
  Serial.print(F("Device address: ")); Serial.println(finger.device_addr, HEX);
  Serial.print(F("Packet len: ")); Serial.println(finger.packet_len);
  Serial.print(F("Baud rate: ")); Serial.println(finger.baud_rate);

  finger.getTemplateCount();

  if (finger.templateCount == 0) {
    Serial.print("Sensor doesn't contain any fingerprint data. Please run the 'enroll' example.");
  }
  else {
    Serial.println("Waiting for valid finger...");
    Serial.print("Sensor contains "); Serial.print(finger.templateCount); Serial.println(" templates");
  }
}

void loop()
{
  //mengecek apakah wifi terkoneksi atau tidak
  if ((WiFi.status() == WL_CONNECTED) && (penguncian == 0)) {
    digitalWrite(ledIndicator, LOW);//mematikan led

    //program untuk membaca database
    HTTPClient http;
    String link = "http://" + host + "/projects/dave/charging_station/readStatus.php?id=1";
    http.begin(link);
    int httpCode = http.GET();
    Serial.println(httpCode);
    if (httpCode > 0)
    {
      String status = http.getString();
      String nilai = getValue(status, ',', 1);
      int statushardware = nilai.toInt();
      Serial.println(nilai);
      if (statushardware == 1) {
        myServo.write(180); //membuat servo berputar 180 derajat
        delay(5000);
        penguncian = 1;
        while (penguncian == 1) {
          Serial.println("mengambil data sensor ");
          firstVal = digitalRead(obstaclePin);//membaca sensor infrared
          Serial.println(firstVal);
          delay(2000);

          if (firstVal == 0)
          {

            penguncian = 0 ;
            kirimdb(idMachine);//memanggil fungsi untuk mengirim database

          }
        }
      }
      else
      {
        myServo.write(60);
      }
    }
    nilai = "";
    delay(1000);
  }


  if (WiFi.status() != WL_CONNECTED)  {

    digitalWrite(ledIndicator, HIGH);//membuat led menyala
    getFingerprintID();
  }
}
//program default fingerprint sampai bawah
uint8_t getFingerprintID() {
  uint8_t p = finger.getImage();
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image taken");
      break;
    case FINGERPRINT_NOFINGER:
      Serial.println("No finger detected");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_IMAGEFAIL:
      Serial.println("Imaging error");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  // OK success!

  p = finger.image2Tz();
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  // OK converted!
  p = finger.fingerSearch();
  if (p == FINGERPRINT_OK) {
    Serial.println("Found a print match!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_NOTFOUND) {
    Serial.println("Did not find a match");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  // found a match!
  Serial.print("Found ID #"); Serial.print(finger.fingerID);
  Serial.print(" with confidence of "); Serial.println(finger.confidence);
  Serial.println(finger.fingerID);
  delay(1000);
  if ((finger.fingerID == 3) || (finger.fingerID == 1)) //mengecek apakah sidik jari yang terdaftar cocok atau tidak
  {
    myServo.write(180);
    delay(5000);
    penguncian = 1;
  }
  while (penguncian == 1) {
    firstVal = digitalRead(obstaclePin);
    Serial.println("mengambil data sensor ");
    Serial.println(firstVal);

    delay(2000);


    if (firstVal == 0)
    {
      myServo.write(60);
      penguncian = 0 ;

    }
  }
  delay(100);
  return finger.fingerID;
}

// returns -1 if failed, otherwise returns ID #
int getFingerprintIDez() {
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK)  return -1;

  p = finger.image2Tz();
  if (p != FINGERPRINT_OK)  return -1;

  p = finger.fingerFastSearch();
  if (p != FINGERPRINT_OK)  return -1;

  // found a match!
  Serial.print("Found ID #"); Serial.print(finger.fingerID);
  Serial.print(" with confidence of "); Serial.println(finger.confidence);




  return finger.fingerID;
}
