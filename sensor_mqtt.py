#!/usr/bin/env python
import math
import time
from ctypes import *
import microstacknode.gps.l80gps
import paho.mqtt.client as mqtt

sensor = CDLL("/home/pi/rpi_sensor_board/sensor.so")

class MMA8491Q_DATA(Structure):
	_fields_  = [("Xout", c_int16),
	("Yout", c_int16),
	("Zout", c_int16)]

class mpl3115a2:
	def __init__(self):
		if (0 == sensor.bcm2835_init()):
			#print "bcm3835 driver init failed."
			return
			
	def writeRegister(self, register, value):
	    sensor.MPL3115A2_WRITE_REGISTER(register, value)
	    
	def readRegister(self, register):
		return sensor.MPL3115A2_READ_REGISTER(register)

	def active(self):
		sensor.MPL3115A2_Active()

	def standby(self):
		sensor.MPL3115A2_Standby()

	def initAlt(self):
		sensor.MPL3115A2_Init_Alt()

	def initBar(self):
		sensor.MPL3115A2_Init_Bar()

	def readAlt(self):
		return sensor.MPL3115A2_Read_Alt()

	def readTemp(self):
		return sensor.MPL3115A2_Read_Temp()

	def setOSR(self, osr):
		sensor.MPL3115A2_SetOSR(osr);

	def setStepTime(self, step):
		sensor.MPL3115A2_SetStepTime(step)

	def getTemp(self):
		t = self.readTemp()
		t_m = (t >> 8) & 0xff;
		t_l = t & 0xff;

		if (t_l > 99):
			t_l = t_l / 1000.0
		else:
			t_l = t_l / 100.0
		return (t_m + t_l)

	def getAlt(self):
		alt = self.readAlt()
		alt_m = alt >> 8 
		alt_l = alt & 0xff
		
		if (alt_l > 99):
			alt_l = alt_l / 1000.0
		else:
			alt_l = alt_l / 100.0
			
		return self.twosToInt(alt_m, 16) + alt_l
	def getBar(self):
		alt = self.readAlt()
		alt_m = alt >> 6 
		alt_l = alt & 0x03
		
		if (alt_l > 99):
			alt_l = alt_l 
		else:
			alt_l = alt_l 

		return (self.twosToInt(alt_m, 18))

	def twosToInt(self, val, len):
		# Convert twos compliment to integer
		if(val & (1 << len - 1)):
			val = val - (1<<len)

		return val

class mma8491q:
	def __init__(self):
		if (0 == sensor.bcm2835_init()):
			#print "bcm3835 driver init failed."
			return	

	def init(self):
		sensor.MMA8491Q_Init()
		
	def enable(self):
		sensor.MMA8491Q_Enable()

	def disEnable(self):
		sensor.MMA8491Q_DisEnable()
		
	def writeRegister(self, register, value):
		sensor.MMA8491Q_WRITE_REGISTER()

	def readRegister(self, register):
		return sensor.MMA8491Q_READ_REGISTER()

	def read(self, data):
		sensor.MMA8491_Read(data)	

	def getAccelerometer(self):
		data = 	MMA8491Q_DATA()
		pdata = pointer(data)
		self.read(pdata)
		return (data.Xout, data.Yout, data.Zout);
		
	def __str__(self):
		ret_str = ""
		(x, y, z) = self.getAccelerometer()
		ret_str += "X: "+str(x) + "  "
		ret_str += "Y: "+str(y) + "  "
		ret_str += "Z: "+str(z)
		
		return ret_str
		
	def twosToInt(self, val, len):
		# Convert twos compliment to integer
		if(val & (1 << len - 1)):
			val = val - (1<<len)

		return val

# initalize the various sensors
mpl = mpl3115a2()
mpl.initAlt()
mpl.active()
time.sleep(1)
mma = mma8491q()
mma.init()
mma.enable()
gps = microstacknode.gps.l80gps.L80GPS()
gpgll = gps.gpgll

# initalize the paho client
mqttc = mqtt.Client(client_id="raspberrypi-mems", clean_session=False, userdata=None)
mqttc.connect("192.168.1.203")
mqttc.loop()

# begin publishing loop of sensor data
while True:
    # publish temperature data
    temper = mpl.getTemp()
    mqttc.publish("pizzapi/mems/temp",temper)

    # publish accelerometer data
    x, y, z = mma.getAccelerometer()
    acoords = "%s,%s,%s" % (x,y,z)
    mqttc.publish("pizzapi/mems/mma8491q",acoords)

    # publish gps data
    gcoords = "%s,%s" % (gpgll['latitude'],gpgll['longitude'])
    mqttc.publish("pizzapi/mems/l80gps",gcoords)
    time.sleep(1)
