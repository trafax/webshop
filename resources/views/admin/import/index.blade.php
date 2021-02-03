@extends('layouts.admin')

@section('content')

    <form method="post" action="{{ route('import.run') }}" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-between align-items-center">
            <h1><i class="bi bi-upload"></i> Importeren</h1>
            <button type="submit" class="btn btn-primary">Importeren</button>
        </div>

        <hr>

        <div class="callout callout-info mt-4 bg-white">
            <h4>Uitleg</h4>
            <p>Het importeren van producten kan gedaan worden via een tabgescheiden .xlsx bestand.</p>
            <p>
                <code>
                    <u>Sku</u> &nbsp; &nbsp; &nbsp;<u>Category</u>&nbsp; &nbsp; <u>Title</u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<u>Price</u>&nbsp; &nbsp; &nbsp;Kleur&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Inches<br>
                    AA1001&nbsp; &nbsp;Fietsen&nbsp; &nbsp; &nbsp;Charmonix S30&nbsp; &nbsp;1999.00&nbsp; &nbsp;{"Rood", "Groen", "Orange"}&nbsp;{"22 inch": "1999.00", "24 inch": "2155.00"}

                </code>
            </p>
            <p>De velden <strong>Sku</strong>, <strong>Category</strong>, <strong>Title</strong> en <strong>Price</strong> zijn verplicht. Deze velden kunnen vervolgd worden door optie velden.</p>
            <p>
                <strong>Optie velden</strong><br>
                De opties moeten in de {""} brackets geplaatst worden. Bijvoorbeeld <strong>{"Rood", "Groen"}</strong>.<br>
                Wanneer een optie een andere prijs heeft dan kan je dat realiseren door de nieuwe erbij te plaatsen: {"Rood": <strong>"10.00"</strong>, "Groen": <strong>"15.00"</strong>}
            </p>
            <p>Download <a href="{{ Config::get('app.shared_url') }}/storage/voorbeeld-import.xlsx"><u>hier</u></a> een voorbeeld .xlsx bestand die u kunt aanpassen.</p>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label class="form-label">Selecteer een .xlsx bestand met de juiste producten die u wilt importeren.</label>
                        <div class="input-group">
                            <input type="file" name="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
