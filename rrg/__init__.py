

from sqlalchemy.orm import sessionmaker

from rrg.models import Client
from rrg.models import Contract
from rrg.models import State
from rrg.models import User
from rrg.models import Invoice

from rrg.models import engine

Session = sessionmaker(bind=engine)

session = Session()


def cleared_invoices_client(client, all_invs):
    """
    filters out clients cleared invoices
    :param client:
    :param all_invs:
    :return:
    """
    for i in all_invs:
        if i.contract.client == client:
            print(i.contract.client.name)
            print(i.id, i.amount, i.date)

    print('returning cleared invoices')

clients = session.query(Client).order_by(Client.name)

for client in clients:
    print(client.name)

states = session.query(State).order_by(State.name)

for state in states:
    print(state.name)

users = session.query(User).order_by(User.firstname, User.lastname)

for user in users:
    print(user.id, user.firstname, user.lastname)


all_invs = session.query(Invoice).order_by(Invoice.date)

for i in all_invs:
    print(i.id, i.amount, i.date)

for c in clients:
    cleared_invoices_client(c, all_invs)


"""
        $cleared = $this->Invoice->find('all', array(
                'conditions'=>array('voided'=>0,'posted'=>1,'cleared'=>1,'client_id'=>$client_id,
                    'mock' => 0,),
                'fields'=>array(
                    'Invoice.id',
                    'Invoice.period_start',
                    'Invoice.period_end',
                    'Invoice.date',
                    'Invoice.terms',
                    'Invoice.notes',
                    'Invoice.amount',
                    'Invoice.contract_id',
                    'ClientsContract.employee_id'),
                'order'=>array('Invoice.date ASC'),
            )
        );"""