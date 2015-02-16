angular.module('commentService', [])

	.factory('Comment', function($http) {

		return {
			get : function() {
				 return $http.get('/allcomments');
			},
			show : function(id) {
				return $http.get('comments/' + id);
			},
			save : function(commentData) {
				return $http({
					method: 'POST',
					url: '/comments',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(commentData)
				});
			},
			destroy : function(id) {
				return $http.delete('/comments/' + id);
			}
		}

	});