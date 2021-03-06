<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--Header-->
	<?php $this->load->view('geral/layout/header') ?>

<body>
<!-- loader -->
<div class="loader">
    <div class="loader-inner ball-triangle-path">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- fim loader -->
	<div class="row">
		<div class="banner-inicio">
			<img src="<?=base_url('assets/third_party/logo/logo-branco.png')?>">
		</div>
		<nav class="navbar navbar-default">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
							data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="<?= site_url()?>"><span class="fa fa-map-marker" style="margin-right: 5px;"></span> Mapa</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?= site_url('contato')?>"><span class="fa fa-phone" style="margin-right: 5px;"></span> Contato</a></li>
						<?php if (getSesUser(['Login'])): ?>
							<li><a href="<?= site_url('dashboard') ?>"><span class="fa fa-user"
																			 style="margin-right: 5px;"></span> <?= getSesUser(['Login']) ?>
								</a></li>
							<input type="hidden" value="<?= getSesUser(['CodUsuario']) ?>" id="verificaUser"/>
						<?php else: ?>
                            <li><a href="<?= site_url('dashboard') ?>"><span class="fa fa-lock"
                                                                             style="margin-right: 5px;"></span>
									Login</a></li>
							<input type="hidden" value="null" id="verificaUser"/>
						<?php endif; ?>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
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
	<!--	<div id="owl-submenu" class="owl-carousel owl-theme hi-icon-wrap hi-icon-effect-8" style="background-color: #1c3e5e;">-->
	<!--		<a href="#" data-id="iconVeterinario" class="hi-icon icon-veterinario iconBusca item"></a>-->
	<!--		<a href="#" data-id="iconPet" class="hi-icon icon-petshop iconBusca item"></a>-->
	<!--		<a href="#" data-id="iconHotel" class="hi-icon icon-hotel iconBusca item"></a>-->
	<!--		<a href="#" data-id="iconAdestrador" class="hi-icon icon-adestrador iconBusca item"></a>-->
	<!--		<a href="#" data-id="iconTaxi" class="hi-icon icon-taxi iconBusca item"></a>-->
	<!--		<a href="#" data-id="todos" class="hi-icon icon-localizacao iconBusca item"></a>-->
	<!--	</div>-->
	<div class="row">
		<div class="container">
			<h3>Você tambem pode estar interessado nos itens abaixo...</h3>
			<!--			<div class="col-lg-12">-->
			<!--				<div id="owl-demo" class="owl-carousel owl-theme menu-recomendacoes">-->
			<!--					<div id="recomendacao"></div>-->
			<!--				</div>-->
			<div id="recomendacao" class="owl-carousel menu-recomendacoes">
			</div>
			<h3 style="text-align: right;">Clique e conheça esses estabelecimentos!</h3>
		</div>
	</div>
	<div class="row" style="margin-top:20px">

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
								<input type="text" id="estabelecimento-busca" data-id-es="" class="form-control"
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
									<button id="pesquisaEsTag" class="btn btn-default my-btn"
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
	</div>
	<div class="container">
		<div class="row">
			<div class="seperator"><i class="fa fa-flag"></i></div>
			<h1 style="text-align: center; margin-bottom: 30px;">3 motivos para ter seu negócio no Guia do Pet!</h1>
			<div class="seperator"><i class="fa fa-flag"></i></div>
			<div class="col-sm-6 col-md-4">
				<div class="thumbnail">
					<img src="<?=base_url('assets/third_party/logo/v1.png')?>" alt="...">
					<div class="caption">
						<h3>O seu negocio no MAPA</h3>
						<p>Com o Guia do Pet, o seu negocio terá mais visibilidade por ser localizado no mapa!</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-4">
				<div class="thumbnail">
					<img src="<?=base_url('assets/third_party/logo/v2.png')?>" alt="...">
					<div class="caption">
						<h3>Divulgação</h3>
						<p>Você pode ter mais de uma plataforma para divulgar o seus serviços e sim, totalmente de graça! </p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-4">
				<div class="thumbnail">
					<img src="<?=base_url('assets/third_party/logo/v3.png')?>" alt="...">
					<div class="caption">
						<h3>Escalabilidade</h3>
						<p>Faça seu negocio alcancar outros públicos, não só em uma cidade!</p>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-12">
				<a href="<?= site_url('registrar') ?>">
                    <button class="btn btn-primary btn-lg my-btn btn-block" style="text-transform: uppercase; margin-top: 20px; margin-bottom: 30px">
					Cadastre-se, é gratuito!!
				</button>
                </a>
			</div>
		</div>
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


		//		$('.owl-carousel').owlCarousel({
		//			loop:true,
		//			items:1,
		//			margin:10,
		//			nav:false,
		//			responsive:{
		//				0:{
		//					items:1,
		//					loop: false,
		//					autoplay: true,
		//					autoplayTimeout: 1000
		//				},
		//				600:{
		//					items:2
		//				},
		//				1000:{
		//					items:6
		//				}
		//			}
		//        });

		$("#recomendacao").owlCarousel({
			jsonPath: site_url + "/api/Estabelecimento/recomendacao/" + $('#verificaUser').val(),
			jsonSuccess: customDataSuccess,
			items: 6, //10 items above 1000px browser width
			itemsDesktop: [1000, 6], //5 items between 1000px and 901px
			itemsDesktopSmall: [900, 4], // betweem 900px and 601px
			itemsTablet: [600, 2], //2 items between 600 and 0;
			autoHeight: true,
			itemsMobile: true
		});

		function customDataSuccess(data) {
			var content = "";
			for (var i in data) {
				var href = site_url + "/estabelecimento/" + data[i].CodEstabelecimento;
				var nome = data[i].Nome;

				content += '<a class="label label-primary label-recomendacao" href="' + href + '">' + nome + '</a>'
			}
			$("#recomendacao").html(content);
		}

		$("#owl-submenu").owlCarousel({
			items: 6, //10 items above 1000px browser width
			itemsDesktop: [1000, 5], //5 items between 1000px and 901px
			itemsDesktopSmall: [900, 3], // betweem 900px and 601px
			itemsTablet: [600, 3], //2 items between 600 and 0;
			itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
		});


		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		});

        $("#categoriaEs, #tag").select2({
            placeholder: 'Selecione uma Opção',
            maximumInputLength: 30
		});


		$.getJSON(site_url + "/api/tags/buscaTag/", function (resultados) {
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
        });

		/*Easy autocomplete para busca de estabelecimentos*/
        var pesquisaEstabelecimento = {
			url: site_url + "/api/estabelecimento/buscaEsOrdenada/",

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
				$("#estabelecimento-busca").attr("data-id-es", id);
				return element.nome;
				console.log(element.nome);
			},
            list: {
                match: {
                    enabled: true
				}

            }
		};

		$("#estabelecimento-busca").easyAutocomplete(pesquisaEstabelecimento);

        /** verifica se o campo de estabelecimento esta preenchido para poder acionar o botao
         *
         * @type {*|jQuery|HTMLElement}
         */
		var input = $('#estabelecimento-busca');
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

		//		$.getJSON(site_url + "/api/Estabelecimento/recomendacao/" + $('#verificaUser').val(), function (resultados) {
		//			var result = " ";
		//
		//			$.each(resultados, function (index, resp) {
		//				var href = site_url + "/estabelecimento/" + resp.CodEstabelecimento;
		//				result += '<div class="item"><a class="label label-primary label-recomendacao" href="' + href + '">' + resp.Nome + '</a></div>';
		//			});
		//			// atribui no campo de tag
		//			$("#recomendacao").html(result);
		//		});


	</script>
</body>
</html>