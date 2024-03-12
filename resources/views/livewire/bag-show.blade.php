<div class="container">
    <h2>Paquetes asociados a la bolsa :{{ $bag->NROSACA }} / {{ $bag->NRODESPACHO }}</h2>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Codigo de Rastreo</th>
                        <th>Destinatario</th>
                        <th>Pais</th>
                        <th>Ciudad</th>
                        <th>Peso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $package)
                        <tr>
                            <td>{{ $package->id }}</td>
                            <td>{{ $package->CODIGO }}</td>
                            <td>{{ $package->DESTINATARIO }}</td>
                            <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                            <td>{{ $package->CUIDAD }}</td>
                            <td>{{ $package->PESO }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>