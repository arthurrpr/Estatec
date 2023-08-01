// Seleciona os inputs de senha e de confirmação de senha
var senhaInput = document.getElementById("senha");
var confirmacaoSenhaInput = document.getElementById("senha_confirmacao");

// Adiciona o evento 'input' ao input de confirmação de senha
confirmacaoSenhaInput.addEventListener("input", function() {
    // Verifica se as senhas são iguais
    var senha = senhaInput.value;
    var confirmacaoSenha = confirmacaoSenhaInput.value;
    var confirmaSenha = document.getElementById("confirma-senha");

    if (senha !== confirmacaoSenha) {
        console.log("As senhas não correspondem");
        // Desabilita o botão de envio
        document.getElementById("cadastrar").disabled = true;
        document.getElementById("alerta-senha").innerHTML = "<span style='color:red; font-weight:bold;'>As senhas não coincidem!<br> As senhas devem conter, ao menos, uma letra maiúscula, um dígito numérico e um caractere especial (*/-)</span>";

    } else {

        // Habilita o botão de envio
        document.getElementById("cadastrar").disabled = false;
        document.getElementById("alerta-senha").innerHTML = ""

    }
});