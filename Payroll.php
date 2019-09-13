<?php

/**
 *
 * @author Ravikumar Raja <r.ravimailid@gmail.com>
 */
 
interface Payroll
{
    public function getSalaryDay($date);
    public function getBonusesDay($date);
}