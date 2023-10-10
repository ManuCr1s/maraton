<form class="needs-validation" enctype="multipart/form-data" id="idForm">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-secondary">Registro de nombres y ubicacion</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="country">Elija Pais</label>
                                <select class="custom-select d-block w-100" id="country" name="pais" required>
                                    <option value="0">Seleccione Pais</option>
                                    <option value="1">Peru</option>
                                    <option value="2">Chile</option>
                                </select>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="document">Tipo documento <span class="text-muted"></span></label>
                                <select class="custom-select d-block w-100" id="document" name ="tipo" required>
                                    <option value="0">Seleccione Documento</option>
                                    <option value="1">Dni</option>
                                    <option value="2">Carnet de Extranjeria</option>
                                </select>
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 ">
                                <label for="lastName">Numero Documento</label>
                                <div class="row">
                                    <div class="col-md-12 d-flex">
                                        <input type="text" class="form-control" id="number_doc" name="numero" placeholder="" value="" required>
                                        <button class="btn btn-primary" id="icon_search"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                                
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" placeholder="" value="" required readonly>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="" value="" required readonly>
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="country">Region</label>
                                <select class="custom-select d-block w-100" id="region" name="region" required>
                                    <option value="9999">Seleccione Region</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid country.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state">Provincia</label>
                                <select class="custom-select d-block w-100" id="provincia" name="provincia" required>
                                    <option value="9999">Seleccione Provincia</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please provide a valid state.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="zip">Distrito</label>
                                <select class="custom-select d-block w-100" id="distrito"  name="distrito"required>
                                    <option value="9999">Seleccione Distrito</option>
                                </select>
                                <div class="invalid-feedback">
                                    Zip code required.
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-secondary">Registro de Categoria y datos de contacto</h6>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="level">Categorias <span class="text-muted"></span></label>
                            <select class="custom-select d-block w-100" id="level" name="level" required>
                                <option value="10">Seleccione Categoria</option>
                                <option value="1">Elite Varones</option>
                                <option value="2">Elite Mujeres</option>
                                <option value="3">Master</option>
                                <option value="4">Juveniles</option>
                                <option value="5">Menores</option>
                                <option value="6">Junior</option>
                                <option value="7">Infantil</option>
                                <option value="8">Habilidades Especiales (Sordo y Mudo)</option>
                                <option value="9">Habilidades Especiales (con ceguera)</option>
                            </select>
                            <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="country">Sexo</label>
                                    <select class="custom-select d-block w-100" id="genrs" name="genrs" required>
                                        <option value="0">Seleccione</option>
                                        <option value="1">Fenenino</option>
                                        <option value="2">Masculino</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid country.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="state">Fecha Nacimiento</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Ingrese su Direccion" value="" required >
                                    <div class="invalid-feedback">
                                        Please provide a valid state.
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName">Direccion</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingrese su Direccion" value="" required >
                                    <div class="invalid-feedback">
                                        Please select a valid country.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="firstName">Numero de Celular</label>
                                    <input type="text" class="form-control" id="celular" name="celular" placeholder="Ingrese Numero de Celular" value="" required >
                                    <div class="invalid-feedback">
                                        Please provide a valid state.
                                    </div>
                                </div>
                        </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-secondary">Registro de Documentos adjuntos</h6>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>Autorizacion de Participacion</div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="format01" name="format01">
                                        <label class="custom-file-label" for="customFile">Seleccione Formato 01</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div>Constancia Medica</div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="format02" name="format02">
                                        <label class="custom-file-label" for="customFile">Seleccione Formato 02</label>
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>Declaracion Jurada</div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="format03" name="format03">
                                        <label class="custom-file-label" for="customFile">Seleccione Formato 03</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div>Deslinde de responsabilidad</div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="format04" name="format04">
                                        <label class="custom-file-label" for="customFile">Seleccione Formato 04</label>
                                    </div>
                                </div>
                        </div>
                        <hr class="my-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Registrarse Ahora</button>
                    </form>