create database fintech_database;
use fintech_database;


#=================================================
# 		Area da administracao
#=================================================
CREATE TABLE grupos(
        codigo_grupo                   INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        nome_grupo					   NVARCHAR(200),	
        descricao                      TEXT, 
        permissoes                     NVARCHAR(100),
        criado_em                      DATETIME,
        atualizado_em                  DATETIME,
        apagado_em					   DATETIME
);

CREATE TABLE senha_config(
		codigo_senha_config	 			INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
		descricao						NVARCHAR(255),
		senha							NVARCHAR(100),
		criado_em                      	DATETIME,
		atualizado_em                  	DATETIME,
		apagado_em					   	DATETIME
);

CREATE TABLE email_config(
		codigo_email_config	 			INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
		email							NVARCHAR(255),
		senha							NVARCHAR(100),
        host_mail						NVARCHAR(100),
        porta							NVARCHAR(20),
        protocolo_tls					NVARCHAR(10),
        protocolo_ssl					NVARCHAR(10),
		criado_em                      	DATETIME,
		atualizado_em                  	DATETIME,
		apagado_em					   	DATETIME
);

CREATE TABLE telegram_config(
		codigo_telegram_config	 		INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
		bot_token						NVARCHAR(255),
		bot_username					NVARCHAR(100),
		criado_em                      	DATETIME,
		atualizado_em                  	DATETIME,
		apagado_em					   	DATETIME
);

CREATE TABLE clientes (
	codigo_cliente	 					INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome_completo						NVARCHAR(255),
    data_nascimento						DATE,
    genero								NVARCHAR(100),
    tipo_documento						NVARCHAR(50),
    documento_identidade				NVARCHAR(100),
    local_de_emissao					NVARCHAR(100),
    data_emissao						DATE,
    data_expiracao						DATE,
    distrito_residencia					NVARCHAR(100),
    cidade_residencia					NVARCHAR(100),
    endereco							NVARCHAR(255),
    celular								NVARCHAR(50),
    celular_alt							NVARCHAR(50),
    email								NVARCHAR(255),
    palavra_passe                  		NVARCHAR(200),
    data_admissao						DATE,
    anexo_documento						TEXT,
    criado_em                      		DATETIME,
	atualizado_em                  		DATETIME,
	apagado_em					   		DATETIME,
    grupos                         		INT UNSIGNED,
	FOREIGN KEY(grupos) REFERENCES grupos(codigo_grupo)
);


CREATE TABLE utilizadores (
        codigo_utilizador              INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, 
		grupos                         INT UNSIGNED,
        nome_utilizador                NVARCHAR(255),	
        utilizador                     NVARCHAR(255), 
        palavra_passe                  NVARCHAR(200), 
        permissoes                     NVARCHAR(100),
        descricao_grupo                NVARCHAR(255), 
        status 						   ENUM('Activo', 'Inactivo', 'Bloqueado') DEFAULT 'Activo',
        criado_em                      DATETIME,
        atualizado_em                  DATETIME,
        apagado_em					   DATETIME,
        FOREIGN KEY(grupos) REFERENCES grupos(codigo_grupo)
);


#===================================================
# CONTAS
#===================================================
CREATE TABLE contas (
        codigo_conta              	   INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
		codigo_cliente                 INT UNSIGNED,	
        numero_conta 				   VARCHAR(20) NOT NULL,
		saldo 						   DECIMAL(15, 2) DEFAULT 0.00,
		data_abertura 				   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		status 						   ENUM('ativa', 'bloqueada', 'fechada') DEFAULT 'ativa',
        criado_em                      DATETIME,
        atualizado_em                  DATETIME,
        apagado_em					   DATETIME,
        FOREIGN KEY (codigo_cliente) REFERENCES clientes(codigo_cliente)
);

CREATE TABLE movimentos (
        codigo_movimento               INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
		codigo_cliente                 INT UNSIGNED,
        data						   DATE,
        data_valor					   DATE,
        referencia					   NVARCHAR(255),
        descricao					   NVARCHAR(255),	
        codigo_conta              	   INT UNSIGNED,
        numero_conta				   VARCHAR(20) NOT NULL,	
        montante					   DECIMAL(15, 2),
        tipo_transacao 				   ENUM('Deposito', 'Transferencia', 'Retirada', 'Pagamento', 'Juros', 'Reembolso',  'Cobrança'),
		talao_transacao				   TEXT,
		#status 					   ENUM('Pendente', 'Aprovado', 'Rejeitado') DEFAULT 'Pendente',
        criado_em                      DATETIME,
        atualizado_em                  DATETIME,
        apagado_em					   DATETIME,
        FOREIGN KEY (codigo_cliente) REFERENCES clientes(codigo_cliente),
        FOREIGN KEY (codigo_conta)   REFERENCES contas(codigo_conta)
);


CREATE TABLE taxas_juros (
		codigo_taxa 				   INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
		tipo_emprestimo 			   NVARCHAR(255),
		taxa_juros 					   DECIMAL(5, 2),
        status 						   ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
		criado_em                      DATETIME,
		atualizado_em                  DATETIME,
		apagado_em					   DATETIME
);


'''CREATE TABLE emprestimos (
    id_emprestimo 					INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente 						INT,
    valor_emprestado 				DECIMAL(15, 2),
    data_solicitacao 				TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tipo_emprestimo 				ENUM('pessoal', 'crédito consignado', 'veículo', 'imóvel'),
    prazo 							INT,  -- prazo em meses
    taxa_juros 						DECIMAL(5, 2),
    status_emprestimo 				ENUM('aprovado', 'pendente', 'negado') DEFAULT 'pendente',
    data_aprovacao 					TIMESTAMP NULL,
    data_pagamento 					TIMESTAMP NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);


CREATE TABLE transacoes (
    id_transacao INT AUTO_INCREMENT PRIMARY KEY,
    id_conta INT,
    tipo_transacao ENUM('depósito', 'saque', 'transferência'),
    valor DECIMAL(15, 2),
    data_transacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    descricao VARCHAR(255),
    FOREIGN KEY (id_conta) REFERENCES contas_bancarias(id_conta)
);


CREATE TABLE pagamentos_emprestimos (
    id_pagamento INT AUTO_INCREMENT PRIMARY KEY,
    id_parcela INT,
    id_conta INT,
    valor_pago DECIMAL(15, 2),
    data_pagamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    metodo_pagamento ENUM('transferência', 'boleto', 'dinheiro'),
    FOREIGN KEY (id_parcela) REFERENCES parcelas_emprestimos(id_parcela),
    FOREIGN KEY (id_conta) REFERENCES contas_bancarias(id_conta)
);'''



INSERT INTO grupos (nome_grupo, descricao, permissoes, criado_em, atualizado_em) 
         VALUES ('Administradores', 'Grupo de gestao da Administradores', '1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111', Now(), Now());



#=============================================
# Triggers
#=============================================

DELIMITER #
CREATE TRIGGER credenciais
    AFTER INSERT ON clientes 
    FOR EACH ROW  
    BEGIN 
        DECLARE permition NVARCHAR(100);
        DECLARE description NVARCHAR(255);

        -- Buscando as permissões do grupo
        SELECT grupos.permissoes INTO permition 
        FROM grupos
        WHERE grupos.codigo_grupo = NEW.grupos
        LIMIT 1;

        -- Buscando a descrição do grupo
        SELECT grupos.nome_grupo INTO description 
        FROM grupos
        WHERE grupos.codigo_grupo = NEW.grupos
        LIMIT 1;

        -- Inserindo os dados na tabela utilizadores_permissoes
        INSERT INTO utilizadores 
            (codigo_utilizador, grupos, nome_utilizador,  utilizador, palavra_passe,  permissoes, descricao_grupo,
             criado_em, atualizado_em )
        VALUES 
            (NEW.codigo_cliente, NEW.grupos,  NEW.nome_completo, NEW.email, NEW.palavra_passe, permition, description,
            now(), now());
    END#

DELIMITER ;

#=====================================
# trigger que gera a conta
#=====================================
DELIMITER $$
CREATE TRIGGER after_cliente_insert
AFTER INSERT ON clientes
FOR EACH ROW
BEGIN
    -- Criar a conta bancária associada ao cliente inserido
    INSERT INTO contas (codigo_cliente, numero_conta, saldo, criado_em, atualizado_em)
    VALUES (
        NEW.codigo_cliente,                                           		-- código_cliente do novo cliente
        CONCAT(YEAR(CURDATE()), LPAD(NEW.codigo_cliente, 10, '0')), 	-- número da conta com o ano + código do cliente
        0.00,                                                         		-- saldo inicial (0,00)
        NOW(),                                                        		-- data de criação
        NOW()                                                         		-- data de atualização
    );
END $$
DELIMITER ;


#=====================================================
# Trigger que actualiza o saldo na hora do depoisito
#=====================================================
DELIMITER $$
CREATE TRIGGER atualizar_saldo_deposito
AFTER INSERT ON movimentos
FOR EACH ROW
BEGIN
    -- Verificar se o tipo de transação é 'Deposito'
    IF NEW.tipo_transacao = 'Deposito' THEN
        -- Atualizar o saldo da conta com o montante do depósito
        UPDATE contas
        SET saldo = saldo + NEW.montante
        WHERE codigo_conta = NEW.codigo_conta;
    END IF;
END $$

DELIMITER ;



#=================================================
# 		Fim da Area da administracao
#=================================================


#===================================================
# Insercoes
#==================================================

INSERT INTO clientes (
    nome_completo, 
    data_nascimento, 
    genero, 
    tipo_documento, 
    documento_identidade, 
    local_de_emissao, 
    data_emissao, 
    data_expiracao, 
    distrito_residencia, 
    cidade_residencia, 
    endereco, 
    celular, 
    celular_alt, 
    email, 
    palavra_passe, 
    data_admissao, 
    anexo_documento, 
    criado_em, 
    atualizado_em, 
    apagado_em, 
    grupos
) VALUES
('Administrador', '1985-04-12', 'Masculino', 'Bilhete', '060123456789J', 'Maputo', '2010-03-15', '2030-03-15', 'Maputo', 'Khamavota', 'Rua das Mahotas, 123', '(11) 98765-4321', '(11) 99876-5432', 'admin@email.com', md5('11admin11'), '2023-02-26', 'documento123.pdf', NOW(), NOW(), NULL, 1);
