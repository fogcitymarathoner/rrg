
from rrg.models import Client
from rrg.models import State
from rrg.models import User


from sqlalchemy.orm import sessionmaker

from sherees_commissions.models import engine

Session = sessionmaker(bind=engine)

session = Session()

clients = session.query(Client).order_by(Client.name)

for client in clients:
    print(client.name)

states = session.query(State).order_by(State.name)

for state in states:
    print(state.name)

users = session.query(User).order_by(User.firstname, User.lastname)

for user in users:
    print(user.id, user.firstname, user.lastname)

