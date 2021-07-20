<?php
    require_once "Connection.class.php";

    class Produtos{
        public function listar(){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();
            try {
                $sql = "SELECT * FROM produtos INNER JOIN categorias ON produtos.id_categoria_fk = categorias.id_categoria WHERE 1";
            
                $consulta = $connection->prepare($sql);
                $consulta->execute();

                $vl = $consulta->rowCount();

                if ($vl > 0) {
                    $dados = $consulta->fetchAll();
                    foreach ($dados as $indice => $dado) {
                        echo '<div class="col-lg-4 col-md-6 text-center '.$dado['nome_categoria'].'">
                                <div class="single-product-item">
                                    <div class="product-image">
                                        <a href="product&id='.$dado['id_produto'].'" id="single-product-item" data-id="'.$dado['id_produto'].'"><img src="commandview/assets/img/images/'.$dado['imagem_produto'].'" alt="'.$dado['nome_produto'].'"></a>
                                    </div>
                                    <h3>'.$dado['nome_produto'].'</h3>
                                    <p class="product-price"><span>P/Quantidade</span> R$'.$dado['preco_produto'].' </p>
                                    <a href="cart" data-id="'.$dado['id_produto'].'"" class="cart-btn"><i class="fas fa-shopping-cart"></i> Adicionar ao carrinho</a>
                                </div>
                            </div>';
                    }
                } else {
                    echo '<div class="col-lg-4 col-md-6 text-center indisponível"></div>
                            <div class="col-lg-4 col-md-6 text-center indisponível">
                                <div class="single-product-item">
                                    <div class="product-image">
                                        <a href="#"><img src="commandview/assets/img/images/productind.jpg" alt="Produtos Indisponíveis"></a>
                                    </div>
                                    <h3>Produtos Indisponíveis</h3>
                                    <p class="product-price"><span>P/Quantidade</span> R$00.00 </p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 text-center indisponível"></div>';
                }
            } catch (PDOException $e) {
                echo "Erro de cadastrar: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }
        
        public function listarCategorias(){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();
            try {
                $sql = "SELECT * FROM categorias WHERE 1 LIMIT 5";
            
                $consulta = $connection->prepare($sql);
                $consulta->execute();

                $vl = $consulta->rowCount();

                if ($vl > 0) {
                    $dados = $consulta->fetchAll();
                    echo '<ul>
                            <li class="li active" data-filter="*">Todos</li>';
                    foreach ($dados as $indice => $dado) {
                        echo '
                        <li class="li" data-filter=".'.$dado['nome_categoria'].'">'.$dado['nome_categoria'].'</li>';
                    }
                    echo "</ul>";
                }
            } catch (PDOException $e) {
                echo "Erro de cadastrar: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }

        public function listarProduto($id_produto){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();
            try {
                $sql = "SELECT * FROM produtos INNER JOIN categorias ON produtos.id_categoria_fk = categorias.id_categoria WHERE id_produto = :id_produto";
            
                $consulta = $connection->prepare($sql);
                $consulta->bindValue(":id_produto", $id_produto);
                $consulta->execute();

                $vl = $consulta->rowCount();

                if ($vl > 0) {
                    $dados = $consulta->fetchAll();
                    foreach ($dados as $dado) {
                        echo $dado["id_produto"]."-&-".$dado["nome_produto"]."-&-".$dado["preco_produto"]."-&-".$dado["quatidade_disponivel"]."-&-".$dado["imagem_produto"]."-&-".$dado["nome_categoria"];
                    }
                }
            } catch (PDOException $e) {
                echo "Erro de cadastrar: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }
        
        public function quantidadeProdutos(){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();
            try {
                $sql = "SELECT * FROM produtos";
            
                $consulta = $connection->prepare($sql);
                $consulta->execute();

                $vl = $consulta->rowCount();

                return $vl;

            } catch (PDOException $e) {
                echo "Erro de cadastrar: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }

        public function cadastrar($categoria, $nome, $preco, $quantidade, $imagem){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();

            try {
                $sql = "INSERT INTO produtos(id_produto, id_categoria_fk, nome_produto, preco_produto, quatidade_disponivel, imagem_produto) VALUES (NULL, :categoria, :nome, :preco, :quantidade, :imagem)";

                $cadastrar = $connection->prepare($sql);
                $cadastrar->bindValue(":categoria", $categoria);
                $cadastrar->bindValue(":nome", $nome);
                $cadastrar->bindValue(":preco", $preco);
                $cadastrar->bindValue(":quantidade", $quantidade);
                $cadastrar->bindValue(":imagem", $imagem);

                if ($cadastrar->execute()) {
                    return $connection->lastInsertId();
                }else{
                    return "alert_notification_error_id!";
                }

            } catch (PDOException $e) {
                echo "Erro de cadastrar: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }
        
        public function cadastrarCorProduto($id_produto, $cor){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();

            try {
                $sql = "INSERT INTO cor_produto (id_cor_produto, id_produto_fk, cor) VALUES (NULL, :id_produto, :cor)";

                $cadastrar = $connection->prepare($sql);
                $cadastrar->bindValue(":id_produto", $id_produto);
                $cadastrar->bindValue(":cor", $cor);
                
                if ($cadastrar->execute()) {
                    return true;
                }else{
                    return false;
                }

            } catch (PDOException $e) {
                echo "Erro de cadastrar: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }

        public function cadastrarTamProduto($id_produto, $tamanho){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();

            try {
                $sql = "INSERT INTO tamanho_produto (id_tamanho_produto, id_produto_fk, tamanho) VALUES (NULL, :id_produto, :tamanho)";

                $cadastrar = $connection->prepare($sql);
                $cadastrar->bindValue(":id_produto", $id_produto);
                $cadastrar->bindValue(":tamanho", $tamanho);

                if ($cadastrar->execute()) {
                    return true;
                }else{
                    return false;
                }

            } catch (PDOException $e) {
                echo "Erro de cadastrar: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }

        public function editar($id_produto,$nome,$preco,$quantidade,$imagem){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();

            try {
                $sql = "UPDATE produtos SET nome_produto = :nome, preco_produto = :preco, quatidade_disponivel = :quantidade, imagem_produto = :imagem WHERE produtos.id_produto = :id_produto";

                $atualizar = $connection->prepare($sql);
                $atualizar->bindValue(":id_produto", $id_produto);
                $atualizar->bindValue(":nome", $nome);
                $atualizar->bindValue(":preco", $preco);
                $atualizar->bindValue(":quantidade", $quantidade);
                $atualizar->bindValue(":imagem", $imagem);

                if ($atualizar->execute()) {
                    return true;
                }else{
                    return false;
                }
                
            } catch (PDOException $e) {
                echo "Erro de cadastrar: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }

        public function apagar($id_produto){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();

            try {
                $sql = "DELETE FROM produtos WHERE produtos.id_produto = :id_produto";

                $apagar = $connection->prepare($sql);
                $apagar->bindValue(":id_produto", $id_produto);

                if ($apagar->execute()) {
                    return true;
                }else{
                    return false;
                }
                
            } catch (PDOException $e) {
                echo "Erro de cadastrar: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }
    }
?>