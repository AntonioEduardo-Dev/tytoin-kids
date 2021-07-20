<?php
    require_once "Connection.class.php";

    class Categorias{
        public function listarCategorias(){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();
            try {
                $sql = "SELECT * FROM categorias";
            
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
        
        public function listarSelectCategorias(){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();
            try {
                $sql = "SELECT * FROM categorias LIMIT 10";
            
                $consulta = $connection->prepare($sql);
                $consulta->execute();

                $vl = $consulta->rowCount();

                if ($vl > 0) {
                    $dados = $consulta->fetchAll();
                    echo '<option value="0" selected style="display: none;">Categoria do produto*</option>';
                    foreach ($dados as $indice => $dado) {
                        echo '<option value="'.$dado['id_categoria'].'">'.$dado['nome_categoria'].'</option>';
                    }
                }
            } catch (PDOException $e) {
                echo "Erro de cadastrar: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }

        public function quantidadeCategorias(){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();
            try {
                $sql = "SELECT * FROM categorias";
            
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

        public function cadastrar($nome){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();
            try {
                $sql = "INSERT INTO categorias(id_categoria, nome_categoria) VALUES (NULL, :nome)";

                $cadastrar = $connection->prepare($sql);
                $cadastrar->bindValue(":nome", $nome);

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

        public function apagarCategorias($id_categoria){
            $objConexao = new Connection();
            $connection = $objConexao->conectar();
            try {

            } catch (PDOException $e) {
                echo "Erro de cadastrar: " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }
    }
?>