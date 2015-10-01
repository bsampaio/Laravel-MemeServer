<div class="wizard-card">
    <h3>Gerar Meme</h3>

    <div class="wizard-input-section">
        <div class="form-group">
            <input type="text" id="top-text" class="form-control" placeholder="Texto de topo (opcional)" data-validate="">
            <img src="" id="selected-img" alt="Selected image" class="img-responsive"/>
            <input type="tel" id="bottom-text" class="form-control" placeholder="Texto de baixo" required="required">
        </div>
    </div>


    <div class="wizard-error">
        <div class="alert alert-danger">
            <span id="error-message"></span>
        </div>
        <a class="btn btn-danger im-done pull-right">Fechar</a>
    </div>

    <div class="wizard-failure">
        <div class="alert alert-warning">
            <strong>There was a problem</strong> submitting the form.
            Please try again in a minute.
        </div>
    </div>

    <div class="wizard-success">
        <div class="row">
            <div class="alert alert-success text-center">
                <span id="success-message"></span>
            </div>
        </div>

        <div class="row">
            <div id="success">
                <img src="" id="success-image" class="img-responsive center" width="60%">
            </div>
        </div>

        <div class="row" style="margin-top: 15px;">

            <div class="col-sm-4">
                <a id="download-button" class="btn btn-default" href="" download="meme.jpg">
                    Faça o Download!
                </a>
            </div>

            <div class="col-sm-4 text-center">
                <a class="btn btn-facebook"><i class="fa fa-facebook"></i></a>
                <a class="btn btn-twitter"><i class="fa fa-twitter"></i></a>
                <a class="btn btn-google-plus"><i class="fa fa-google-plus"></i></a>
            </div>

            <div class="col-sm-4">
                <a class="btn btn-success im-done pull-right">Concluir</a>
            </div>
        </div>
    </div>
</div>