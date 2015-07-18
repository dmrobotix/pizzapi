#!/usr/bin/env python
import time
from ctypes import *
import microstacknode.gps.l80gps
import paho.mqtt.client as mqtt

sensor = CDLL("/home/pi/rpi_sensor_board/sensor.so")


class Mma8491qData(Structure):
    _fields_ = [("Xout", c_int16), ("Yout", c_int16), ("Zout", c_int16)]


class Mpl3115a2:
    def __init__(self):
        if 0 == sensor.bcm2835_init():
            # print "bcm3835 driver init failed."
            return

    def writeregister(self, register, value):
        sensor.MPL3115A2_WRITE_REGISTER(register, value)

    def readregister(self, register):
        return sensor.MPL3115A2_READ_REGISTER(register)

    def active(self):
        sensor.MPL3115A2_Active()

    def standby(self):
        sensor.MPL3115A2_Standby()

    def initalt(self):
        sensor.MPL3115A2_Init_Alt()

    def initbar(self):
        sensor.MPL3115A2_Init_Bar()

    def readalt(self):
        return sensor.MPL3115A2_Read_Alt()

    def readtemp(self):
        return sensor.MPL3115A2_Read_Temp()

    def setosr(self, osr):
        sensor.MPL3115A2_SetOSR(osr)

    def setsteptime(self, step):
        sensor.MPL3115A2_SetStepTime(step)

    def gettemp(self):
        t = self.readtemp()
        t_m = (t >> 8) & 0xff
        t_l = t & 0xff

        if t_l > 99:
            t_l /= 1000.0
        else:
            t_l /= 100.0
        return t_m + t_l

    def getalt(self):
        alt = self.readalt()
        alt_m = alt >> 8
        alt_l = alt & 0xff

        if alt_l > 99:
            alt_l /= 1000.0
        else:
            alt_l /= 100.0

        return self.twostoint(alt_m, 16) + alt_l

    def getbar(self):
        alt = self.readalt()
        alt_m = alt >> 6
        alt_l = alt & 0x03

        if alt_l > 99:
            alt_l = alt_l
        else:
            alt_l = alt_l

        return self.twostoint(alt_m, 18)

    def twostoint(self, val, len):
        # Convert twos compliment to integer
        if val & (1 << len - 1):
            val -= (1 << len)

        return val


class Mma8491q:
    def __init__(self):
        if 0 == sensor.bcm2835_init():
            # print "bcm3835 driver init failed."
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

    def getaccelerometer(self):
        data = Mma8491qData()
        pdata = pointer(data)
        self.read(pdata)
        return data.Xout, data.Yout, data.Zout

    def __str__(self):
        ret_str = ""
        xx, yy, zz = self.getaccelerometer()
        ret_str += "X: " + str(xx) + "  "
        ret_str += "Y: " + str(yy) + "  "
        ret_str += "Z: " + str(zz)

        return ret_str

    def twostoint(self, val, length):
        # Convert twos compliment to integer
        if val & (1 << length - 1):
            val -= (1 << length)

        return val

# initialize the various sensors
mpl = Mpl3115a2()
mpl.initalt()
mpl.active()
time.sleep(1)
mma = Mma8491q()
mma.init()
mma.enable()
gps = microstacknode.gps.l80gps.L80GPS()
gpgll = gps.gpgll

# initialize the paho client
mqttc = mqtt.Client(client_id="raspberrypi-mems", clean_session=False, userdata=None)
mqttc.connect("192.168.1.203")
mqttc.loop()

# begin publishing loop of sensor data
while True:
    # publish temperature data
    temper = mpl.gettemp()
    mqttc.publish("pizzapi/mems/temp", temper)

    # publish accelerometer data
    x, y, z = mma.getaccelerometer()
    acoords = "%s,%s,%s" % (x, y, z)
    mqttc.publish("pizzapi/mems/mma8491q", acoords)

    # publish gps data
    gcoords = "%s,%s" % (gpgll['latitude'], gpgll['longitude'])
    mqttc.publish("pizzapi/mems/l80gps", gcoords)
    time.sleep(1)
