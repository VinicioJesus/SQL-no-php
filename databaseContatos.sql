#comentário em linha
/*
comentario em bloco
*/


#é obrigatório escolher o database que será utilizado
use dbcontatos;

#cria um database
create database dbcontatos;
show tables;

create table tblcontatos (
	idcontato int not null auto_increment primary key,
    nome varchar(80) not null,
    telefone varchar(18),
    celular varchar(19) not null,
    email varchar(320) not null,
    obs text    
);
select * from tblcontatos;

insert into tblcontatos (nome, telefone, celular, email, obs)
	values ('Carlao','(011)4772-4800', '(011)97878-0777',
    'maria@gmail.com', 'testando o mysql');   

select * from tblcontatos order by idcontato desc;
insert into tblcontatos (nome, telefone, celular, email, obs)
	values ('Carlao','(011)4772-4800', '(011)97878-0777',
    'maria@gmail.com', 'testando o mysql'); 
delete from tblcontatos where idcontato = 3;

desc tblcontatos







