var app = angular.module('myApp',['ngRoute']);

//configuración de rutas
app.config(function($routeProvider) {
	$routeProvider
	.when('/', {
		templateUrl: 'templates/inicio.html'
	})
	.when('/examen', {
		controller: 'questionController',
		templateUrl: 'templates/examen.html'
	})
	.when('/resultado', {
		controller: 'resultController',
		templateUrl: 'templates/resultado.html'
	})
	.otherwise({
		redirectTo: '/'
	});
});

//controlador de pregunta, que controla toda la lógica
app.controller('questionController', function($scope, Questions, $location, Score) {
	$scope.questions = Questions;
	$scope.numberQuestion = 1;
	$scope.question = $scope.questions[$scope.numberQuestion-1];
	$scope.checked = false;
	var responses = [];

	$scope.chooseKey = function(){
		angular.forEach($scope.question.keys, function(value, key) {
		  	value.active = false;
		});
		$scope.checked = true;
		this.key.active = true;
	};

	$scope.pass = function() {
		if($scope.numberQuestion < $scope.questions.length){
			$scope.numberQuestion++;
			$scope.question = $scope.questions[$scope.numberQuestion-1];
			$scope.checked = false;
		}
	};

	$scope.qualify = function() {
		angular.forEach($scope.question.keys, function(value, key) {
			if (value.active)
				responses.push({id:$scope.question.id,key:value.id});
		});
		$scope.pass();
		$scope.checked = false;
	};

	$scope.endExam = function() {
		$scope.qualify();
		angular.forEach($scope.questions, function(question, i) {
			angular.forEach(responses, function(item,j){
				if(question.id == item.id && question.response == item.key){
					Score.score = Score.score + 2;
				}
			});
		});
		$location.url('/resultado');
	};
});

//controlador de resultado
app.controller('resultController', function($scope, Score) {
	$scope.score = Score.score;

});

//servicio que permite psar la variable "score entre el controlador de examen y resultado"
app.factory('Score', function(){
	return {score: 0};
});

//Fabrica que retorna la lista de preguntas
app.factory('Questions', function(){
	return [
		{
			id: 1,
			premise: '¿Cómo se produce la inyección de dependencias en AngularJS?',
			keys: [
				{
					id: 1,
					text: 'AngularJS posee un ente que trabaja como inyector',
					active: false
				},
				{
					id: 2,
					text: 'La inyección de dependencias no existe en angularJS',
					active: false
				},
				{
					id: 3,
					text: 'Cualquier componente de AngularJS puede ser requerido por otro componente como si fuera un parámetro',
					active: false
				},
				{
					id: 4,
					text: 'Las alternativas 1 y 3 son correctas',
					active: false
				}
			],
			status: true,
			visible: false,
			response: 4
		},
		{
			id: 2,
			premise: '¿Cuál es la definición correcta de un closure?',
			keys: [
				{
					id: 1,
					text: 'Los closures son funciones que manejan variables independientes. En otras palabras, la función definida en el closure "recuerda" el entorno en el que se ha creado.',
					active: false
				},
				{
					id: 2,
					text: 'Son funciones que retornan algo necesariamente',
					active: false
				},
				{
					id: 3,
					text: 'Son funciones comunes',
					active: false
				},
				{
					id: 4,
					text: 'funciones especiales dentro de otras funciones',
					active: false
				}
			],
			status: true,
			visible: false,
			response: 1
		},
		{
			id: 3,
			premise: 'Node.JS es:',
			keys: [
				{
					id: 1,
					text: 'Un servidor de eventos',
					active: false
				},
				{
					id: 2,
					text: 'Un servidor de prototipos',
					active: false
				},
				{
					id: 3,
					text: 'Una libreria de frontend',
					active: false
				},
				{
					id: 4,
					text: 'Un servidor que solo permite ejecutar proyectos con stack Javascript',
					active: false
				}
			],
			status: true,
			visible: false,
			response: 1
		},
		{
			id: 4,
			premise: '¿Cuál de estos es el contexto de Node?',
			keys: [
				{
					id: 1,
					text: 'window',
					active: false
				},
				{
					id: 2,
					text: 'global',
					active: false
				},
				{
					id: 3,
					text: 'document',
					active: false
				},
				{
					id: 4,
					text: 'local',
					active: false
				}
			],
			status: true,
			visible: false,
			response: 2
		},
		{
			id: 5,
			premise: 'Una de estas funciones está mal escrita:',
			keys: [
				{
					id: 1,
					text: 'function hola(){}',
					active: false
				},
				{
					id: 2,
					text: 'var hola = function hola(){}',
					active: false
				},
				{
					id: 3,
					text: 'var hola = function(){}',
					active: false
				},
				{
					id: 4,
					text: 'function hola(){}',
					active: false
				}
			],
			status: true,
			visible: false,
			response: 2
		},
		{
			id: 6,
			premise: 'new Ninja("Carlos")',
			keys: [
				{
					id: 1,
					text: 'Es un objeto',
					active: false
				},
				{
					id: 2,
					text: 'Inicializa un objeto',
					active: false
				},
				{
					id: 3,
					text: 'Inicializa un objeto Ninja con un parámetro',
					active: false
				},
				{
					id: 4,
					text: 'Inicializa un objeto con un apuntador y pasa un parámetro',
					active: false
				}
			],
			status: true,
			visible: false,
			response: 4
		},
		{
			id: 7,
			premise: '¿Javascript es single thread o “hilo único”?',
			keys: [
				{
					id: 1,
					text: 'Si',
					active: false
				},
				{
					id: 2,
					text: 'No',
					active: false
				},
				{
					id: 3,
					text: 'sí, porqué solo hay un evento en ejecución',
					active: false
				},
				{
					id: 4,
					text: 'no, porque hay muchos eventos ejecutándose',
					active: false
				}
			],
			status: true,
			visible: false,
			response: 3
		},
		{
			id: 8,
			premise: 'Scope:',
			keys: [
				{
					id: 1,
					text: 'Es el contexto en el que se inicializa una variable, función u objeto',
					active: false
				},
				{
					id: 2,
					text: 'Es donde creo un objeto y se mantiene',
					active: false
				},
				{
					id: 3,
					text: 'Es el contexto de un objeto',
					active: false
				},
				{
					id: 4,
					text: 'Es la parte donde inicializo las variables',
					active: false
				}
			],
			status: true,
			visible: false,
			response: 1
		},
		{
			id: 9,
			premise: 'De estas afirmaciones ¿cuál no es correcta?',
			keys: [
				{
					id: 1,
					text: 'Se puede crear una función de forma literal',
					active: false
				},
				{
					id: 2,
					text: 'A una función se le puede pasar argumentos',
					active: false
				},
				{
					id: 3,
					text: 'Una función puede retornar argumentos',
					active: false
				},
				{
					id: 4,
					text: 'A una función se le deben crear sus propiedades dinámicamente y asignarlas',
					active: false
				}
			],
			status: true,
			visible: false,
			response: 4
		},
		{
			id: 10,
			premise: 'Prototype:',
			keys: [
				{
					id: 1,
					text: 'Es la forma de agregar un método a un objeto',
					active: false
				},
				{
					id: 2,
					text: 'Es la parte de un objeto que extiende su funcionalidad',
					active: false
				},
				{
					id: 3,
					text: 'Es una propiedad de un objeto',
					active: false
				},
				{
					id: 4,
					text: 'Es la propiedad de un objeto que extiende su funcionalidad',
					active: false
				}
			],
			status: true,
			visible: false,
			response: 2
		}

	];
});