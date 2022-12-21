<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Student as ModelsStudent;
use CodeIgniter\Debug\Toolbar\Collectors\Files;
use CodeIgniter\Files\File;
use Faker\Extension\Helper;

use function PHPUnit\Framework\fileExists;

class Student extends BaseController
{
    protected $ruleValidations;
    protected $filePath;

    public function __construct()
    {
        $this->ruleValidations = [
            'student_name' => 'required',
            'student_street' => 'required',
            'student_number' => 'required',
            'student_complement' => 'required',
            'student_district' => 'required',
            'student_city' => 'required',
            'student_state' => 'required',
            'student_zipcode' => 'required',

        ];
        $this->filePath = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR;
        helper('filesystem');
        directory_mirror($this->filePath, ROOTPATH.'public');
    }

    public function index()
    {
        return view('student/index');
    }

    public function list()
    {
        $student = new \App\Models\Student();
        $students = $student->findAll();
        return view('student/list', ['students' => $students]);
    }

    public function create()
    {
        return view('student/create');
    }

    public function store()
    {
        // validar dados
        $validation =  \Config\Services::validation();

        $dataSaveStudent = $this->request->getPost();

        if (!empty($this->request->getFile('student_picture'))) {
            $this->getRulesByFiles();
            $arquivo = $this->upload('student_picture', 'alunos');
            $dataSaveStudent['student_picture'] = $arquivo->getFilename();
        }

        $validation->setRules($this->ruleValidations);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('errors', $validation->getErrors());
            redirect()->back()->withInput();
        }

        // salvar dados
        $student = new ModelsStudent();
        $student->save($dataSaveStudent);
        session()->setFlashdata('success', 'Aluno cadastrado com sucesso!');

        return view('student/success', ['student' => $this->request->getPost('student_name'), 'message' => 'Aluno cadastrado com sucesso!']);

        return redirect()->to(url_to('student.list'));
    }

    public function edit($studentId)
    {
        // carregar dados do aluno
        $student = new \App\Models\Student();
        $student = $student->find($studentId);
        if (!$student) {
            session()->setFlashdata('error', 'Aluno não encontrado!');
            return redirect()->to(url_to('student.list'));
        }
        return view('student/edit', ['student' => $student]);
    }

    public function update($studentId)
    {
        // carrega dados do aluno
        $student = new \App\Models\Student();
        $student = $student->find($studentId);
        if (!$student) {
            session()->setFlashdata('error', 'Aluno não encontrado!');
            return redirect()->to(url_to('student.list'));
        }
        // validar dados
        $validation =  \Config\Services::validation();

        $dataSaveStudent = $this->request->getPost();

        if (!empty($this->request->getFile('student_picture')->getFilename())) {
            
            $this->deleteFile($student['student_picture']);
            $this->getRulesByFiles();
            $arquivo = $this->upload('student_picture', 'alunos');
            $dataSaveStudent['student_picture'] = $arquivo->getFilename();
        }

        $validation->setRules($this->ruleValidations);

        if (!$validation->withRequest($this->request)->run()) {
            $this->deleteFile($student['student_picture']);
            session()->setFlashdata('errors', $validation->getErrors());
            redirect()->back()->withInput();
        }

        $student = new ModelsStudent();
        $student->where('student_id', $studentId)
            ->set($dataSaveStudent)
            ->update();

        session()->setFlashdata('success', 'Aluno atualizado com sucesso!');

        return view('student/success', ['student' => $this->request->getPost('student_name'), 'message' => 'Aluno atualizado com sucesso!']);

        return redirect()->to(url_to('student.list'));
    }

    public function destroy($studentId)
    {
        // carregar dados do aluno
        $student = new ModelsStudent();
        $student = $student->find($studentId);
        if (!$student) {
            session()->setFlashdata('error', 'Aluno não encontrado!');
            return redirect()->to(url_to('student.list'));
        }
        // deletar foto
        $this->deleteFile($student['student_picture']);
        
        // deletar aluno
        $student = new ModelsStudent();
        $student->where('student_id', $studentId)->delete();

        session()->setFlashdata('success', 'Aluno deletado com sucesso!');
        return redirect()->to(url_to('student.list'));
    }

    private function deletefile($file)
    {   
        if (file_exists($this->filePath . 'alunos/' . $file))
            unlink($this->filePath . 'alunos/' . $file);
    }

    private function getRulesByFiles(): void
    {
        $this->ruleValidations['student_picture'] = [
            'rules' => 'uploaded[student_picture]'
                . '|is_image[student_picture]'
                . '|mime_in[student_picture,image/jpg,image/jpeg]' //somente permitido JPG e JPEG
                . '|max_size[student_picture,2000]'
                . '|max_dims[student_picture,4024,700]',
        ];
    }

    //Helper upload
    public function upload($file, $path = 'uploads')
    {
        $picture = $this->request->getFile($file);
        if (!$picture->hasMoved()) {
            $filepath = $this->filePath . $picture->store($path);
            return new File($filepath);
        }
        return false;
    }
}
