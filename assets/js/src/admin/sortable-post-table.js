jQuery((function($) {
	var st = {};

	/**
	 * Adds a data attribute with the value of the posts sort order.
	 *
	 * @param {function} callback Function to be executed once complete.
	 *
	 * @return  {void}
	 */
	st.updateSortOrderDataAttrs = function(callback) {
		st.sortParentElem.find('tr').each(function(index, el) {
			var that = $(el);
			if (typeof that.data('sortorder') === 'undefined') {
				that.attr('data-sortorder', index);
			} // if()
			that.data('sortorder', index);
		});

		if (typeof callback !== 'undefined') {
			callback();
		} // if()
	}; // st.updateSortOrderDataAttrs()

	/**
	 * Updates the sort order.
	 *
	 * @return  {void}
	 */
	st.updateSortOrder = function() {
		var getVar   = new RegExp('post_type' + "=([^&]*)", "i").exec(window.location.search),
				ajaxData = {
					action   : 'mdg_sortable_posts_table_update_post',
					posts    : [],
					postType : getVar[1]
				}
		;

		st.sortParentElem.find('tr').each(function(index, el) {
			var that  = $(el),
					idVal = that.attr('id').replace('post-',''),
					sortOrder = that.data('sortorder')
			;
			ajaxData.posts.push( idVal + '|' + sortOrder );
		});

		$.post(ajaxurl, ajaxData, function(data) {
			console.log(data);
		});
	}; // st.updateSortOrder

	/**
	 * Initializes sortable post table.
	 *
	 * @return  {void}
	 */
	st.init = function() {
		st.sortParentElem = $('#the-list');

		if ( st.sortParentElem.length === 0 ) {
			return;
		} // if()

		st.sortParentElem.sortable();

		st.updateSortOrderDataAttrs();

		st.sortParentElem.on( "sortupdate", function() {
			st.updateSortOrderDataAttrs(function(){
				st.updateSortOrder();
			});
		});
	}; // st.init()

	$(document).ready(function() {
		st.init();
	});
})(jQuery));