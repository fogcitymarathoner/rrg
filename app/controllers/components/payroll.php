<?php
App::import('Component', 'PayrollHelper');
App::import('Model', 'Payroll');
class PayrollComponent extends Object {
    function padded_count($count,$payments)
    {
        if(strlen($count)<2 && count($payments) >9)
        {
            $count = str_pad ($count,2,'0',STR_PAD_LEFT);
        }

        if(count($payments) < 10)
        {
            $count = str_pad ($count,1,'0',STR_PAD_LEFT);
        }
        return $count;
    }
    function writeout_distribution_scripts($xmlhome,$step1_script,$step2_script,$id)
    {

        Configure::write('debug',2); // this makes the action available in routes
        if($id)
        {
        $paydir = $xmlhome.'payrolls/';
        $filename = $paydir.'paystub_transmittals/'.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'_encryption_step1_splitA_encrypt.sh';
        if ($f = fopen($filename,'w'))
        {
            foreach($step1_script as $line)
            {
                fwrite($f, $line);
                fwrite($f, chr(10) );//. chr(13)
            }
            fclose($f);
        } else
        {
            print "could not open step1 script".$filename;
        }
        $filename = $paydir.'paystub_transmittals/'.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'_encryption_step2_email.sh';
        if ($f = fopen($filename,'w'))
        {
            foreach($step2_script as $line)
            {
                fwrite($f, $line);
                fwrite($f, chr(13) . chr(10));
            }
            fclose($f);
        } else
        {
            print "could not open step2 script".$filename;
        }
        } else {
            print " payroll component function writeout_distribution_scripts needs an valid id";
        }
    }
    function prefill_label_form($payroll,$user)
    {
        $fixobj=array();
        $fixobj['mode']=0;
        $fixobj['fixture-random']=$payroll['Payroll']['securitytoken'].'.json';
        $fixobj['user_id']=$user['User']['id'];
        $fixobj['user_email']=$user['User']['email'];
        $fixobj['row']=0;
        $fixobj['column']=0;
        $fixobj['Employee']=Array();
        foreach($payroll['EmployeesPayment'] as $pay)
        {
            $fixobj['Employee'][]=$pay['employee_id'];
        }
        $jsonComp = new JsonComponent;
        $fixstr = $jsonComp->json_label_fixture($fixobj);
        // grandfather older payrolls that didn't have security tokens made.
        if ($fixobj['fixture-random']== Null)
        {
            $pwhelper = new PasswordHelperComponent();
            $prModel = new Payroll();
            $payroll['Payroll']['securitytoken'] = $pwhelper->generatePaycheckToken();
            $fixobj['fixture-random'] = $payroll['Payroll']['securitytoken'].'.json';;
            $prModel->save($payroll);
        }
        $fully_qualified_fixture_filename =$jsonComp->labelFixtureFullyQualifiedFilename($fixobj);
        $f = fopen($fully_qualified_fixture_filename.'.json','w+');
        fwrite($f,$fixstr);
        fclose($f);
        return $fixstr;

    }
    function updateTotal($id = null) {
        Configure::write('debug',0); // this makes the action available in routes
        if($id)
        {
            $prModel = new Payroll();
            $prModel->recursive = 1;
            $payroll = $prModel->read(null, $id);
            $payTotal = 0;
            foreach ($payroll['EmployeesPayment'] as $payrollItem):
                $payTotal += $payrollItem['amount'];
            endforeach;
            $payroll['Payroll']['amount']= $payTotal;
            $prModel->save($payroll['Payroll']);
            return $prModel->read(null, $id);
        } else {
            print 'no id parameter in updateTotal of payroll component';
        }
    }
}
