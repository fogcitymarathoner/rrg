__author__ = 'marc'
import os
import re
from datetime import datetime as dt
from datetime import timedelta as td
import boto
from boto.s3.key import Key
from fabric.api import run
from fabric.api import get
from fabric.operations import put
from fabric.api import local
from fabric.api import settings
from fabric.api import env

from fabric.context_managers import cd
from fabric.context_managers import lcd
"""
GLOBALS - START
"""
JETBRAINS = 'phpstorm'
BUCKET_NAME = 'amydocker'
# throw away archives older than EXPIIRATIONDAYS on both local and S3
EXPIIRATIONDAYS = 30

TIMESTAMP_FORMAT = '%Y-%m-%d-%H-%M-%S'

# calculate project name and S3 folder name

parray = os.path.dirname(os.path.realpath(__file__)).split(os.sep)

S3FOLDER = parray[len(parray)-1]

BASE_DIR = '.' # relative, absolute puts c: in front
SRC = BASE_DIR


try:

    AWS_ACCESS_KEY_ID = os.environ['AWS_ACCESS_KEY_ID']
    AWS_SECRET_ACCESS_KEY = os.environ['AWS_SECRET_ACCESS_KEY']
except Exception, e:
    print(e)
    quit()

if os.name == 'nt':

    try:

        HOSTNAME = os.environ['COMPUTNERNAME']
    except Exception, e:
        print(e)
        quit()
else:
    try:

        HOSTNAME = os.environ['HOSTNAME']
    except Exception, e:
        print(e)
        quit()


BACKUPEXPIRATION = td(EXPIIRATIONDAYS) # delete backups older than 30 days both local and S3
BASE_DIR = '.' # relative, absolute puts c: in front
SRC = BASE_DIR
print('OS = %s'%os.name)



"""
GLOBALS - END
"""
#


"""
S3 SETUP - START
"""
key = Key(BUCKET_NAME)
#
#
#  Connect to the bucket
#

conn = boto.connect_s3(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY)
if (conn.lookup(BUCKET_NAME)):
	print('----- bucket already exists! -----')
else:
	print('----- creating bucket -----')
	conn.create_bucket(BUCKET_NAME)

bucket = conn.get_bucket(BUCKET_NAME)

bucketlist = bucket.list()

key = boto.s3.key.Key(bucket)
"""
S3 SETUP - END
"""
#
#
#

def backup(PROJECT_NAME):

    # tar command setup args
    if os.name == 'nt':

        archive_file_extension = '7z'
        ARCHCMD = '7z'
        BACKUPSDIR ='D:/backups'

        LOCALARCHIVETARGETDIR = os.path.join(BACKUPSDIR, HOSTNAME, JETBRAINS)
        archive_filename =  '%s-%s.%s'%(dt.now().strftime(TIMESTAMP_FORMAT), PROJECT_NAME, archive_file_extension)
        archive_filename_fullpath = os.path.join(LOCALARCHIVETARGETDIR, archive_filename)

        TAREXCLUDES = ' -x!node_modules -x!.tmp -x!*bower_components ' \
        '-x!.sass-cache -x!*.pyc -x!.idea'
        TARARGS = '%s -t7z '%TAREXCLUDES
        TARCMD = '%s a %s %s %s'%(ARCHCMD, archive_filename_fullpath, TARARGS, SRC)
    else:
        archive_file_extension = 'tar.gz'
        ARCHCMD = 'tar'

        BACKUPSDIR ='/media/sf_backups/'
        LOCALARCHIVETARGETDIR = os.path.join(BACKUPSDIR, HOSTNAME, JETBRAINS)
        archive_filename =  '%s-%s.%s'%(dt.now().strftime(TIMESTAMP_FORMAT), PROJECT_NAME, archive_file_extension)
        archive_filename_fullpath = os.path.join(LOCALARCHIVETARGETDIR, archive_filename)

        TAREXCLUDES = '--exclude=".tmp" --exclude="*/node_modules/*" --exclude="*/bower_components/*" ' \
        '--exclude=".sass-cache" --exclude="*.pyc" --exclude=".idea"'
        TARARGS = '%s '%TAREXCLUDES
        TARCMD = '%s  %s -czf %s %s'%(ARCHCMD, TARARGS, archive_filename_fullpath, SRC)


    TARFILEPATTERN = "[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]-[0-9][0-9]-[0-9][0-9]-[0-9][0-9]-%s.%s"%(PROJECT_NAME, archive_file_extension)

    S3FILEPATTERN = S3FOLDER+TARFILEPATTERN
    target_name = '%s/%s'%(S3FOLDER, archive_filename)
    #
    # build the timestamped archive file
    #

    # make sure there us a backup directory
    try:
        os.makedirs(LOCALARCHIVETARGETDIR)
    except OSError:
        if not os.path.isdir(LOCALARCHIVETARGETDIR):
            raise
    # build the archive

    print('Backing up to directory - %s'%LOCALARCHIVETARGETDIR)
    print('using cmd = %s'%TARCMD)
    local(TARCMD)

    bucket_object_list = []
    for f in bucketlist:
        bucket_object_list.append(f.name)


    key.key = target_name
    print 'uploading STARTING %s to %s: %s'%(archive_filename_fullpath, target_name,dt.now())
    key.set_contents_from_filename(archive_filename_fullpath)
    print 'upload %s FINISHED: %s'%(archive_filename_fullpath, dt.now())
    #
    # delete files over a month old, locally and on server
    #
    expiration = dt.now() - BACKUPEXPIRATION
    for f in bucketlist:

        if re.match(S3FILEPATTERN, f.name):

            dstr = f.name[len(S3FOLDER):len(S3FOLDER)+10]

            fdate = dt.strptime(dstr, "%Y-%m-%d")

            if fdate < expiration:
                bucket.delete_key(f.name)
                print('deleted %s from s3'%f.name)
                f_name_local = os.path.join(LOCALARCHIVETARGETDIR, f.name[len(S3FOLDER):])

                if os.path.isfile(f_name_local):
                    os.remove(f_name_local)
                    print('deleted %s from local'%f_name_local)


def backup_db(PROJECT_NAME, MYSQL_HOST, MYSQL_PORT, MYSQL_DB, MYSQL_USER, MYSQL_PASSWORD):
    if os.name == 'nt':
        raise NotImplementedError

    else:
        archive_file_extension = 'sql.tar.gz'
        sql_file_extension = 'sql'
        ARCHCMD = 'tar'


        try:

            HOME = os.environ['HOME']
        except Exception, e:
            print(e)
            quit()

        BACKUPSDIR = HOME+'/backups'
        LOCALARCHIVETARGETDIR = os.path.join(BACKUPSDIR, HOSTNAME, JETBRAINS)

        # make sure there us a backup directory
        try:
            os.makedirs(LOCALARCHIVETARGETDIR)
        except OSError:
            if not os.path.isdir(LOCALARCHIVETARGETDIR):
                raise
        print 'backing up to %s' % LOCALARCHIVETARGETDIR
        os.chdir(LOCALARCHIVETARGETDIR)
        archive_filename =  '%s-%s.%s'%(dt.now().strftime(TIMESTAMP_FORMAT), PROJECT_NAME, archive_file_extension)
        archive_filename_fullpath = os.path.join(LOCALARCHIVETARGETDIR, archive_filename)

        db_archive_filename =  '%s-%s.%s'%(dt.now().strftime(TIMESTAMP_FORMAT), PROJECT_NAME, sql_file_extension)
        db_archive_filename_fullpath = os.path.join(LOCALARCHIVETARGETDIR, db_archive_filename)

        TAREXCLUDES = ' '
        TARARGS = '%s ' % TAREXCLUDES
        TARCMD = '%s  %s -czf %s %s' % (ARCHCMD, TARARGS, archive_filename_fullpath, db_archive_filename)
        print TARCMD

    TARFILEPATTERN = "[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]-[0-9][0-9]-[0-9][0-9]-[0-9][0-9]-%s.%s"%(PROJECT_NAME, archive_file_extension)

    S3FILEPATTERN = S3FOLDER+TARFILEPATTERN
    target_name = '%s/%s'%(S3FOLDER, archive_filename)

    #
    # build the timestamped archive file
    #

    # build the archive
    DBDUMPCMD = 'mysqldump -u%s -p%s %s > %s' % (MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB, db_archive_filename_fullpath)
    print('Dumping Database - %s' % LOCALARCHIVETARGETDIR)
    print('using cmd = %s' % DBDUMPCMD)
    local(DBDUMPCMD)
    print('Backing up to directory - %s' % LOCALARCHIVETARGETDIR)
    print('using cmd = %s' % TARCMD)

    local(TARCMD)
    os.remove(db_archive_filename_fullpath)
    key.key = target_name
    print 'uploading STARTING %s to %s: %s'%(archive_filename_fullpath, target_name, dt.now())
    key.set_contents_from_filename(archive_filename_fullpath)
    print 'upload %s FINISHED: %s'%(archive_filename_fullpath, dt.now())
    #
    # delete files over a month old, locally and on server
    #
    expiration = dt.now() - BACKUPEXPIRATION
    for f in bucketlist:
        parray = f.name.split('/')
        filename = parray[len(parray)-1]
        if re.match(TARFILEPATTERN, filename):

            farray = f.name.split('/')
            fname = farray[len(farray)-1]
            dstr = fname[0:10]

            fdate = dt.strptime(dstr, "%Y-%m-%d")
            
            if fdate < expiration:
                bucket.delete_key(f.name)
                print('deleted %s from s3'%f.name)
                f_name_local = os.path.join(LOCALARCHIVETARGETDIR, f.name[len(S3FOLDER):])

                if os.path.isfile(f_name_local):
                    os.remove(f_name_local)
                    print('deleted %s from local'%f_name_local)
