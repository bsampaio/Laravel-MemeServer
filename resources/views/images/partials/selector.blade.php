<div class="wizard-card" data-cardname="group">
    <h3>Seleção de Imagem</h3>

    <div class="wizard-input-section">
        <p>
            Selecione uma das imagens abaixo.
        </p>

        <select id="images" class="image-picker">
            @foreach($images as $image)
                <option data-img-src="{{$image['path']}}" value="{{$image['name']}}">{{$image['name']}}</option>
            @endforeach
        </select>
    </div>
</div>