#!/usr/local/bin/python
import datetime
import os
#only working in Bash interactive shell
today = datetime.date.today()
print today
keys = os.environ.keys()
osdic=os.environ
newpath = osdic['PATH']+';c:\\cygwin\\bin'
#print newpath
os.environ['PATH']=newpath
#keys.sort()
#for k in keys:
#    print '%s:%s'%(k,osdic[k])

print os.getenv('PATH')
strtoday = str(today)
logfile = 'app/tmp/'+strtoday+'.log'
cmd = 'git status | grep -v tmp > %s'%(logfile)
os.system (cmd)
cmd = 'cat %s'%(logfile)
os.system (cmd)
