<?= $this->extend('student/layout') ?>
<?= $this->section('content') ?>
<h1>Cadastrar novo Aluno</h1>

<?php if (session()->has('error')) : ?>
    <div class="trigger trigger-error" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div> 
<?php endif; ?>

<form action="<?=url_to('student.store')?>" method="post" enctype="multipart/form-data">

    <label for="nome">Nome</label>
    <input type="text" name="student_name" id="student_name" placeholder="Nome">

    <label for="endereco">CEP</label>
    <input type="text" name="student_zipcode" id="student_zipcode" placeholder="CEP">

    <label for="endereco">Endereço</label>
    <input type="text" name="student_street" id="student_street" placeholder="Rua">

    <label for="endereco">Número</label>
    <input type="text" name="student_number" id="student_number" placeholder="Número">

    <label for="endereco">Complemento</label>
    <input type="text" name="student_complement" id="student_complement" placeholder="Complemento">

    <label for="endereco">Bairro</label>
    <input type="text" name="student_district" id="student_district" placeholder="Bairro">

    <label for="endereco">Cidade</label>
    <input type="text" name="student_city" id="student_city" placeholder="Cidade">

    <label for="endereco">Estado</label>
    <input type="text" name="student_state" id="student_state" placeholder="Estado">

    <label for="endereco">País</label>
    <input type="text" name="student_country" id="student_country" placeholder="País">

    <label for="foto">Foto</label>
    <input name="student_picture" type="file">

    <input type="submit" value="Submit">
</form>


<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    //jquery ajax viacep
    $(document).ready(function() {
        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#student_street").val("");
            $("#student_district").val("");
            $("#student_city").val("");
            $("#student_state").val("");
            $("#student_country").val("");
        }

        //Quando o campo cep perde o foco.
        $("#student_zipcode").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#student_street").val("...");
                    $("#student_district").val("...");
                    $("#student_city").val("...");
                    $("#student_state").val("...");
                    $("#student_country").val("...");
                    
                    $.ajax({
                        url: 'https://viacep.com.br/ws/'+ cep +'/json/?callback=?',
                        dataType: 'json',
                        success: function(resposta) {
                            console.log(resposta)
                            if (!("erro" in resposta)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#student_street").val(resposta.logradouro);
                                $("#student_district").val(resposta.bairro);
                                $("#student_city").val(resposta.localidade);
                                $("#student_state").val(resposta.uf);
                                $("#student_country").val("Brasil");
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });
    });
</script>
<?= $this->endSection() ?>