<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notify         = false;
        $credentials    = $request->only([
            'course_id',
        ]);
        
        $validation = Validator::make($credentials,[
            'course_id' => 'sometimes|required|numeric|exists:courses,id',
        ]);
        if (!$validation->fails()) {

            $students = Student::orderBy('name', 'ASC');
            if (!empty($credentials['course_id'])) {
                $students->where('course_id', $credentials['course_id']);    
            }
            $message    = ['message' => [__('Todos los elementos')]];
            $status     = 'success';
            $data       = $students->paginate(30);

        } else {
            $message    = $validation->messages();
            $status     = 'warning';
            $data       = false;
        }
       
        return response([
            'notify'        => $notify,
            'data'          => $data,
            'status'        => $status,
            'message'       => $message
        ],200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notify  = true;
        
        $credentials = $request->only([
            'email',
            'name',
            'phone',
            'course_id',
        ]);

        $validation = Validator::make($credentials,[
            'email'     => 'required|max:255|email|unique:students,email',
            'name'      => 'required|min:3|max:50',
            'phone'     => 'required|min:3|max:50',
            'course_id' => 'required|numeric|exists:courses,id'
        ]);

        if (!$validation->fails()) {
            $iOrC = Student::firstOrCreate($credentials);

            $message    = ['message' => [__('Gracias')]];
            $status     = 'success';
            $data       = $iOrC;
        }else{
            $message    = $validation->messages();
            $status     = 'warning';
            $data       = false;

        }

        return response([
            'notify'        => $notify,
            'data'          => $data,
            'status'        => $status,
            'message'       => $message
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $notify = true;
        $credentials = $request->only([
            'email',
            'name',
            'phone',
            'course_id',
        ]);

        $validation = Validator::make($credentials,[
            'email'     => 'required|max:255|email|unique:students,email,'.$student->id,
            'name'      => 'required|min:3|max:50',
            'phone'     => 'required|min:3|max:50|unique:students,phone,'.$student->id,
            'course_id' => 'required|numeric|exists:courses,id'
        ]);

        if (!$validation->fails()) {

            foreach ($credentials as $key => $value) {
                if ($credentials[$key] == $student[$key]) {
                    unset($credentials[$key]);
                }
            }

            if (count($credentials)) {
                $okUpdate = $student->fill($credentials)->save();

                    if ($okUpdate) {
                        $message    = ['message' => [__('Elemento actualizado')]];
                        $status     = 'success';
                        $data       = $student;
                    } else {
                        $message    = ['message' => [__('Vaya, algo salió mal en nuestros servidores.')]];
                        $status     = 'warning';
                        $data       = false;
                    }

            } else {
                $message    = ['message' => [__('Nada nuevo para actualizar')]];
                $status     = 'success';
                $data       = false;
            }

        }else{
            $message    = $validation->messages();
            $status     = 'warning';
            $data       = false;
        }

        return response([
            'notify'        => $notify,
            'data'          => $data,
            'status'        => $status,
            'message'       => $message
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $notify = true;

        $okDelete = $student->delete();

        if ($okDelete) {
            $message    = ['message' => [__('Elemento eliminado')]];
            $status     = 'success';
            $data       = false;
        } else {
            $message    = ['message' => [__('Vaya, algo salió mal en nuestros servidores.')]];
            $status     = 'warning';
            $data       = false;
        }
       
        return response([
            'notify'        => $notify,
            'data'          => $data,
            'status'        => $status,
            'message'       => $message
        ],200);
    }
}
