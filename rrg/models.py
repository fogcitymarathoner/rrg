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

engine = create_engine(
             'mysql+mysqldb://%s:%s@%s:%s/rrg' % (
             DB_USER, DB_PASS, MYSQL_PORT_3306_TCP_ADDR, MYSQL_PORT_3306_TCP_PORT))


Base = declarative_base()

# Models for Commissions, Invoices, and Invoice Items are in sherees_commissions


class Client(Base):

    __tablename__ = 'clients'

    id = Column(Integer, primary_key=True)
    contract_id = Column(Integer)
    date = Column(Date)
    po = Column(String)
    employerexpenserate = Column(Float)
    terms = Column(Integer)
    timecard = Column(Boolean)
    notes = Column(String)
    period_start = Column(Date)
    period_end = Column(Date)

    posted = Column(Boolean)
    cleared = Column(Boolean)
    cleared_date = Column(Date)
    prcleared = Column(Boolean)
    timecard_receipt_sent = Column(Boolean)
    message = Column(TEXT)
    
    amount = Column(Float)
    voided = Column(Boolean)

    token = Column(String)
    view_count = Column(Integer)
    mock = Column(Boolean)
    timecard_document = Column(TEXT)
    created_date = Column(Date)
    modified_date = Column(Date)
    created_user_id = Column(Integer)
    modified_user_id = Column(Integer)
    last_sync_time = Column(TIMESTAMP)
