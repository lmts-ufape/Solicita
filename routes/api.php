<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Auth')->group(function(){
    Route::post('requisicaos/esqueciSenha', 'ForgotPasswordController@sendResetLinkEmailApi');
});

Route::namespace('Api')->group(function(){


	Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');
	Route::get('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend');

	Route::post('login', 'UsersApiController@login');
	Route::post('register', 'UsersApiController@register');
	Route::post('logout', 'UsersApiController@logout');

    Route::prefix('cursos')->group(function(){
        Route::get('/', 'CursoController@index');
    });

    Route::prefix('instituicaos')->group(function(){
        Route::get('/', 'InstituicaoController@index');
    });

    Route::prefix('unidades')->group(function(){
        Route::get('/', 'UnidadeController@index');
    });

    Route::prefix('documentos')->group(function(){
        Route::get('/', 'DocumentoController@index');
    });


	
	Route::group(['middleware' => 'auth:api'], function(){
		Route::post('details', 'UsersApiController@details')->middleware('verified');
	}); // will work only when user has verified the email

	// Route::post('/register', 'AuthController@register');
	// Route::post('/login', 'AuthController@login');
	// Route::post('/logout', 'AuthController@logout');

	Route::group(['middleware'=>['jwt.auth']], function(){

		Route::prefix('requisicaos')->group(function(){
			Route::get('/', 'RequisicaoController@index');
			Route::get('/listarRequisicoes', 'RequisicaoController@listarRequisicoes');
			Route::get('/preparaNovaRequisicao', 'RequisicaoController@preparaNovaRequisicao');
			Route::post('/novaRequisicao', 'RequisicaoController@novaRequisicao');
			Route::post('/excluirRequisicao', 'RequisicaoController@excluirRequisicao');

		});

		Route::prefix('alunos')->group(function(){
			Route::get('/', 'AlunoController@index');
		});

		Route::prefix('requisicao_documentos')->group(function(){
			Route::get('/', 'RequisicaoDocumentoController@index');
		});

        Route::prefix('perfils')->group(function(){
            Route::post('/', 'PerfilAlunoController@index');//
            Route::post('/editarInfo', 'PerfilAlunoController@editarInfo');//
            Route::post('/storeEditarInfo', 'PerfilAlunoController@storeEditarInfo');//
            Route::post('/storeAlterarSenha', 'PerfilAlunoController@storeAlterarSenha');//
            Route::post('/adicionaPerfil', 'PerfilAlunoController@adicionaPerfil');//
            Route::post('/salvaPerfil', 'PerfilAlunoController@salvaPerfil');
            Route::post('/excluirPerfil', 'PerfilAlunoController@excluirPerfil');//
            Route::post('/definirPerfilDefault', 'PerfilAlunoController@definirPerfilDefault');//
        });

	});
});
