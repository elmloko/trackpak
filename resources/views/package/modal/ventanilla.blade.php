<!-- Modal de búsqueda de paquete -->
<div class="modal fade" id="buscarPaqueteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscar Paquete DD Ventanilla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para buscar un paquete por código -->
                <form action="{{ route('packages.buscarPaquete') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="codigo">Código del Paquete</label>
                        <input type="text" class="form-control" id="codigo" name="codigo">
                    </div>
                    @if (auth()->user()->Regional == 'LA PAZ')
                        <div class="form-group">
                            <label for="zona">Zona</label>
                            <select class="form-control" id="zona" name="zona">
                                <option value="ACHACHICALA">ACHACHICALA</option>
                                <option value="ACHUMANI">ACHUMANI</option>
                                <option value="ALTO OBRAJES">ALTO OBRAJES</option>
                                <option value="AUQUISAMANA">AUQUISAMAÑA</option>
                                <option value="BELLA VISTA / BOLONIA">BELLA VISTA / BOLONIA</option>
                                <option value="BUENOS AIRES">BUENOS AIRES</option>
                                <option value="CALACOTO">CALACOTO</option>
                                <option value="CEMENTERIO">CEMENTERIO</option>
                                <option value="CENTRO">CENTRO</option>
                                <option value="CIUDADELA FERROVIARIA">CIUDADELA FERROVIARIA</option>
                                <option value="COTA COTA / CHASQUIPAMPA">COTA COTA / CHASQUIPAMPA</option>
                                <option value="EL ALTO">EL ALTO</option>
                                <option value="FLORIDA">FLORIDA</option>
                                <option value="IRPAVI">IRPAVI</option>
                                <option value="LA PORTADA">LA PORTADA</option>
                                <option value="LLOJETA">LLOJETA</option>
                                <option value="LOS ANDES">LOS ANDES</option>
                                <option value="LOS PINOS / SAN MIGUEL">LOS PINOS / SAN MIGUEL</option>
                                <option value="MALLASILLA">MALLASILLA</option>
                                <option value="MIRAFLORES">MIRAFLORES</option>
                                <option value="MUNAYPATA">MUNAYPATA</option>
                                <option value="OBRAJES">OBRAJES</option>
                                <option value="PAMPAHASSI">PAMPAHASSI</option>
                                <option value="PASANKERI">PASANKERI</option>
                                <option value="PERIFERICA">PERIFERICA</option>
                                <option value="PROVINCIA">PROVINCIA</option>
                                <option value="PURA PURA">PURA PURA</option>
                                <option value="ROSARIO GRAN PODER">ROSARIO GRAN PODER</option>
                                <option value="SAN PEDRO">SAN PEDRO</option>
                                <option value="SAN SEBASTIAN">SAN SEBASTIAN</option>
                                <option value="SEGUENCOMA">SEGUENCOMA</option>
                                <option value="SOPOCACHI">SOPOCACHI</option>
                                <option value="TEMBLADERANI">TEMBLADERANI</option>
                                <option value="VILLA ARMONIA">VILLA ARMONIA</option>
                                <option value="VILLA COPACABANA">VILLA COPACABANA</option>
                                <option value="VILLA EL CARMEN">VILLA EL CARMEN</option>
                                <option value="VILLA FATIMA">VILLA FATIMA</option>
                                <option value="VILLA NUEVA POTOSI">VILLA NUEVA POTOSI</option>
                                <option value="VILLA PABON">VILLA PABON</option>
                                <option value="VILLA SALOME">VILLA SALOME</option>
                                <option value="VILLA SAN ANTONIO">VILLA SAN ANTONIO</option>
                                <option value="VILLA VICTORIA">VILLA VICTORIA</option>
                                <option value="VINO TINTO">VINO TINTO</option>
                                <option value="ZONA NORTE">ZONA NORTE</option>
                                <option value="PROVINCIA">PROVINCIA</option>
                                <option value="PG1A">PG1A</option>
                                <option value="PG2A">PG2A</option>
                                <option value="PG3A">PG3A</option>
                                <option value="PG4A">PG4A</option>
                                <option value="PG5A">PG5A</option>
                                <option value="PG1B">PG1B</option>
                                <option value="PG2B">PG2B</option>
                                <option value="PG3B">PG3B</option>
                                <option value="PG4B">PG4B</option>
                                <option value="PG5B">PG5B</option>
                                <option value="PG1C">PG1C</option>
                                <option value="PG2C">PG2C</option>
                                <option value="PG3C">PG3C</option>
                                <option value="PG4C">PG4C</option>
                                <option value="PG5C">PG5C</option>
                                <option value="PG1D">PG1D</option>
                                <option value="PG2D">PG2D</option>
                                <option value="PG3D">PG3D</option>
                                <option value="PG4D">PG4D</option>
                                <option value="PG5D">PG5D</option>
                            </select>
                        </div>
                    @else
                    @endif
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
