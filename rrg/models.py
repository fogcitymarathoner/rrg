"""
does not work on alpine because libmysqlclient-dev package is not available.
"""
import os
from datetime import datetime as dt
from sqlalchemy import create_engine
from sqlalchemy import Column
from sqlalchemy import Integer
from sqlalchemy import String
from sqlalchemy import Date
from sqlalchemy import Float
from sqlalchemy import Boolean
from sqlalchemy import TIMESTAMP
from sqlalchemy import TEXT
from sqlalchemy import ForeignKey

from sqlalchemy.orm import relationship

from sqlalchemy.ext.declarative import declarative_base
import xml.etree.ElementTree as ET

from s3_mysql_backup import TIMESTAMP_FORMAT
from sherees_commissions.models import MissingEnvVar
from sherees_commissions.models import Invoice

try:
    env_str = 'DB_USER'
    if os.getenv(env_str) is None:
       raise MissingEnvVar('%s is not set' % env_str)
    else:
       DB_USER = os.getenv(env_str)

    env_str = 'DB_PASS'
    if os.getenv(env_str) is None:
       raise MissingEnvVar('%s is not set' % env_str)
    else:
       DB_PASS = os.getenv(env_str)

    env_str = 'MYSQL_PORT_3306_TCP_ADDR'
    if os.getenv(env_str) is None:
       raise MissingEnvVar('%s is not set' % env_str)
    else:
       MYSQL_PORT_3306_TCP_ADDR = os.getenv(env_str)

    env_str = 'MYSQL_PORT_3306_TCP_PORT'
    if os.getenv(env_str) is None:
       raise MissingEnvVar('%s is not set' % env_str)
    else:
       MYSQL_PORT_3306_TCP_PORT = os.getenv(env_str)

except MissingEnvVar as e:
    print(e.value)
    raise


Base = declarative_base()

# Models for Commissions, Invoices, and Invoice Items are in sherees_commissions


class State(Base):

    __tablename__ = 'states'

    id = Column(Integer, primary_key=True)
    post_ab = Column(String)
    capital = Column(String)
    date = Column(String)
    flower = Column(String)
    name = Column(String)
    state_no = Column(String)


class User(Base):

    __tablename__ = 'users'

    id = Column(Integer, primary_key=True)
    firstname = Column(String)
    lastname = Column(String)


class Client(Base):

    __tablename__ = 'clients'

    id = Column(Integer, primary_key=True)
    name = Column(String)
    street1 = Column(String)
    street2 = Column(String)
    city = Column(String)
    state_id = Column(Integer)
    zip = Column(String)
    active = Column(Boolean)
    terms = Column(Integer)
    hq = Column(Boolean)
    modified_date = Column(Date)
    created_date = Column(Date)
    modified_user = Column(Integer)
    created_user = Column(Integer)
    last_sync_time = Column(Date)

