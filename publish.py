##################################
# Publish to raspberrypi-server #
#################################

# import libraries

import paho.mqtt.publish as publish

# publish.single("pizzapi/test/hello", "hello, picad. you sweet thing.", hostname="99.45.10.156")
publish.single("pizzapi/test/hello", "hello, picad. you sweet thing.", hostname="192.168.1.203")
