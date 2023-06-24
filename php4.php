<?php
    $nota1 = 6;
    $nota2 = 8;
    $media = ($nota1 + $nota2) / 2;

    if($media > 7){
        echo "Média:  ".$media . "<br>";
        echo "Aluno aprovado.";
    }elseif($media <7) {
        echo "Média: ".$media ."<br>";
        echo "Aluno reprovado";
    }else{
        echo "Média: ".$media."<br>";
        echo "Aluno em recuperação.";
    }

    