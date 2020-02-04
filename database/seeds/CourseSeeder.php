<?php

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array(
                'name'  => 'primero'
            ),
            array(
                'name'  => 'segundo'
            ),
            array(
                'name'  => 'tercero'
            ),
            array(
                'name'  => 'cuarto'
            ),
            array(
                'name'  => 'quinto'
            ),
            array(
                'name'  => 'sesto'
            ),
            array(
                'name'  => 'séptimo'
            ),
            array(
                'name'  => 'octavo'
            ),
            array(
                'name'  => 'noveno'
            ),
            array(
                'name'  => 'décimo'
            ),
            array(
                'name'  => 'un décimo'
            )
        ];
        
        
        foreach ($datos as $key => $value) {
            Course::create($value);
        }
    }
}
