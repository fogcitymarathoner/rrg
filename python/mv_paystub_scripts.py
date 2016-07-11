#!/home/marc/envs/rrg_dj/bin/python
import os
import sys
import getopt
import re
import shutil
#mv -f /home/marc/cakedata/rrg/payrolls/paystub_transmittals/*.sh /home/timecards/payroll_work/payroll_work
path ='/home/marc/cakedata/rrg/payrolls/paystub_transmittals/'
dest='/home/timecards/payroll_work/payroll_work'
findlist = os.walk(path)
for paths, dirs, files in findlist:
  for file in files:
    if file[-2:] == "sh":
      destfile = os.path.join(dest,file)
      shutil.move(os.path.join(path,file),destfile)
      print "moving %s %s"%(os.path.join(path,file),destfile)
