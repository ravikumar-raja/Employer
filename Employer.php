<?php
/**
 *
 * @author Ravikumar Raja <r.ravimailid@gmail.com>
 */

namespace Employer;

class Employer implements Payroll
{

    /**
    * Get Salary Date
    *
    * @return date
    */
    public function getSalaryDay($date)
    {
        $dayOfTheWeek = date('N', strtotime($date));
        if ($dayOfTheWeek > 5) {
            if ($dayOfTheWeek == 6) {
                return date('d-m-Y', strtotime($date . '-1 days'));
            } else {
                return date('d-m-Y', strtotime($date . '-2 days'));
            }
        } else {
            return $date;
        }
    }

    /**
    * Get Bonuses Date
    *
    * @return date
    */
    public function getBonusesDay($date)
    {
        $date = date('d-m-Y', strtotime($date . '+14 days'));
        $day  = date('N', strtotime($date));
        if ($day > 5) {
            if ($day == 6) {
                return date('d-m-Y', strtotime($date . '+4 days'));
            } else {
                return date('d-m-Y', strtotime($date . '+3 days'));
            }
        } else {
            return $date;
        }
    }
}

if (isset($argv[1])) {
    $filePath  = $argv[1];
    $directory = dirname($filePath);
    
    if (!is_dir($directory)) {
        die('The Directory $directory does not exist');
    }

    $currentMonth = date('m');
    $x = 0; $y = 1;
    $output = array();
    $output[] = array(
        'Month',
        'Salary Payment Date',
        'Salary Bonus Date'
    );

    $obj = new Employer();

    for ($i = $currentMonth; $i <= 12; $i++) {
        $data     = array();
        $data[]   = date('F', strtotime("+$x month"));
        $data[]   = $obj->getSalaryDay(date('t-m-Y', strtotime("+$x month")));
        $data[]   = $obj->getBonusesDay(date('01-m-Y', strtotime("+$y month")));
        $output[] = $data;
        $x++;
        $y++;
    }
    
    $fileOpen = fopen($filePath, 'wb');
    foreach ($output as $line) {
        fputcsv($fileOpen, $line);
    }
    fclose($fileOpen); 
    
} else {
    die('Could you please enter the file path?');
}