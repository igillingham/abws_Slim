import json
import urllib2
from base64 import encodestring
request = urllib2.Request('http://abapi.iangillingham.net/aw/name/5')
r = urllib2.urlopen(request)
print r.getcode()
print r.headers["content-type"]
data = r.read()
print data
decoded = json.loads(data) 
print decoded

id = decoded['id']
name = decoded['name']
print "Name of item {0:s} is: {1:s}".format(id, name)


