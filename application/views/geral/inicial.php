<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--Header-->
	<?php $this->load->view('geral/layout/header') ?>
<body>
	<div class="row">
		<div class="banner-inicio">
			<img src="<?=base_url('assets/third_party/logo/logo-branco.png')?>">
		</div>
		<div class="sub-menu">
			<div class="container">
				<section>
					<div class="hi-icon-wrap hi-icon-effect-8">
						<a href="#" data-id="iconVeterinario" class="hi-icon icon-veterinario iconBusca"></a>
						<a href="#" data-id="iconPet" class="hi-icon icon-petshop iconBusca"></a>
						<a href="#" data-id="iconHotel" class="hi-icon icon-hotel iconBusca"></a>
						<a href="#" data-id="iconAdestrador" class="hi-icon icon-adestrador iconBusca"></a>
						<a href="#" data-id="iconTaxi" class="hi-icon icon-taxi iconBusca"></a>
						<a href="#" data-id="todos" class="hi-icon icon-localizacao iconBusca"></a>
					</div>
				</section>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="container">
			<!-- owl carousel -->
			<h3>Pessoas na sua região também pesquisaram...</h3>
			<div class="col-lg-12 menu-recomendacoes owl-carousel owl-theme">
				<a class="label label-primary item">Recomendação 01</a>
				<a class="label label-primary item">Recomendação 02</a>
				<a class="label label-primary item">Recomendação 03</a>
				<a class="label label-primary item">Recomendação 04</a>
				<a class="label label-primary item">Recomendação 05</a>
				<a class="label label-primary item">Recomendação 06</a>
			</div>
		</div>
	</div>
	<div class="row">
		<!--<div class="col-lg-12 col-md-12 col-xs-12">
			<div class="navbar navbar-default">
				<a href="#" id="testeOff">Teste</a>
			</div>
		</div>-->
		<div class="col-lg-3 col-md-4 col-xs-12 menu-lateral">
            <div class="panel panel-default panel-inicial">
				<div class="panel-heading">
					<h3>Opções de Pesquisa</h3>
				</div>
				<div class="panel-body">
					<form>
						<div class="form-group">
							<label for="categoria">Estabelecimentos por categoria</label>
                            <select class="form-control" id="categoriaEs">
								<option>Selecione uma Categoria</option>
								<?php if(count($cat)):?>
									<?php foreach ($cat as $list):?>
										<option value="<?=$list['CodCategoria']?>"><?=$list['Nome']?></option>
									<?php endforeach;?>
								<?php else:?>
									<option value="0">Nenhuma categoria cadastrada</option>
								<?php endif;?>
							</select>
						</div>

						<div class="form-group">
							<label for="estabelecimentos">Estabelecimentos</label>
                            <div class="input-group">
                                <input type="text" id="estabelecimento-ajax" data-id-es="" class="form-control"
                                       placeholder="Informe o nome do estabelecimento">
                                <span class="input-group-btn">
									<button id="pesquisaEs" disabled="disabled" class="btn btn-default my-btn"
                                            type="button" style="height: 34px; color:#fff;"><i
                                            class="fa fa-search fa-lg"></i> </button>
								  </span>
                            </div><!-- /input-group -->
						</div>
						<div class="form-group">
							<label for="tag">Tag - Palavras-Chave</label>
                            <div class="input-group">
                                <select class="form-control" id="tag" multiple="multiple" data-tag-id="">
                                </select>
                                <span class="input-group-btn">
									<button id="pesquisaEsTag" disabled="disabled" class="btn btn-default my-btn"
                                            type="button" style="height: 34px; color:#fff;"><i
                                            class="fa fa-search fa-lg"></i> </button>
								</span>
                            </div>
						</div>
						<div class="form-group">
							<label>Avaliação</label><br>
                            <select id="avaliacao">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</div>
						<div class="form-group">
							<label>Pesquisa por proximidade</label><br>
                            <a class="btn btn-primary btn-lg my-btn" id="btnLocalizacao">Ativar minha localização</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-9 col-md-8 col-xs-12" style="padding: 0px">
			<div id="mapa"></div>
		</div>
		<div id="result"></div>
	</div>
	<!-- FOOTER -->

	<footer>
		<div class="container">
		<p class="pull-right"><a href="#">Topo</a></p>
		<p>&copy; 2016 Guia do Pet, Todos os direitos reservados.</p>
		</div>
	</footer>

	<?php $this->load->view('geral/layout/scripts') ?>


	<script>
		
		$('.owl-carousel').owlCarousel({
			loop:false,
			margin:10,
			nav:false,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:3
				},
				1000:{
					items:6
				}
			}
        });

		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		});

        $("#categoriaEs, #tag").select2({
            placeholder: 'Selecione uma Opção',
            maximumInputLength: 30
		});


        $.getJSON("api/tags/buscaTag/", function (resultados) {
            var tags = " ";
            $.each(resultados, function (index, resp) {
                //tags += '{id: '+resp.codTag+', text: '+resp.tag+'},';
                // cria os options com os dados do json
                tags += '<option value="' + resp.codTag + '">' + resp.tag + '</option>';
            });
            // atribui no campo de tag
            $("#tag").html(tags);
        });

        $("#tag").change(function () {
            var str = [];
            $('#tag :selected').each(function (i, selecionado) {
                str.push($(selecionado).val());
            });
            $(this).attr('data-tag-id', str);
            console.log(str);
        });

		/*Easy autocomplete para busca de estabelecimentos*/
        var pesquisaEstabelecimento = {
            url: "<?php echo site_url(); ?>" + "/api/estabelecimento/buscaEsOrdenada/",

            categories: [{
                listLocation: "Clinica Veterinária",
                maxNumberOfElements: 10,
                header: "--- Clinicas Veterinárias ---"
            }, {
                listLocation: "Pet Shop",
                maxNumberOfElements: 10,
                header: "--- Pet Shops ---"
            }, {
                listLocation: "Hoteis para Pet",
                maxNumberOfElements: 10,
                header: "--- Hoteis para Pet ---"
            }, {
                listLocation: "Adestradores",
                maxNumberOfElements: 10,
                header: "--- Adestradores ---"
            }, {
                listLocation: "Taxi Pet",
                maxNumberOfElements: 10,
                header: "--- Taxi Pet ---"
            }
            ],

			getValue: function(element) {
                var id = parseFloat(element.idEs);
                $("#estabelecimento-ajax").attr("data-id-es", id);
				return element.nome;
			},
            list: {
                match: {
                    enabled: true
				}

            }
		};

        $("#estabelecimento-ajax").easyAutocomplete(pesquisaEstabelecimento);

        /** verifica se o campo de estabelecimento esta preenchido para poder acionar o botao
         *
         * @type {*|jQuery|HTMLElement}
         */
        var input = $('#estabelecimento-ajax');
        input.on('keyup', verificarInputs);

        function verificarInputs() {
            var preenchidos = true;
            input.each(function () {
                if (!this.value) {
                    preenchidos = false;
                    return false;
                }
            });
            $('#pesquisaEs').prop('disabled', !preenchidos);
        }

        $('#avaliacao').barrating({
			theme: 'fontawesome-stars'
		});


	</script>
</body>
</html>