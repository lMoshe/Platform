(function (Q, $, window, document, undefined) {

/**
 * Places Tools
 * @module Places-tools
 */

var Users = Q.Users;
var Streams = Q.Streams;
var Places = Q.Places;

/**
 * Allows the logged-in user to select/add areas to locations
 * @class Places areas
 * @constructor
 * @param {Object} options used to pass options
 * @param {String} options.publisherId Location stream publisher id
 * @param {String} options.streamName Location stream name
 * @param {String} options.stream Location stream
 * @param {Object} options.location Location object
 */
Q.Tool.define("Places/areas", function (options) {
	var tool = this;
	var state = this.state;
	var $te = $(tool.element);

	Q.addStylesheet('Q/plugins/Places/css/areas.css');

	Q.Text.get('Places/content', function (err, text) {
		state.text = text;

		// get location stream and run refresh method
		tool.refresh();
	});

},

{ // default options here
	publisherId: null,
	streamName: null,
	location: null,
	stream: null,
	areaSelected: null
},

{ // methods go here
	/**
	 * Refresh the display
	 * @method refresh
	 */
	refresh: function () {
		var tool = this;
		var state = tool.state;
		var $te = $(tool.element);
		var qFilterTool = tool.$(".Q_tool.Q_filter_tool")[0];
		qFilterTool = qFilterTool ? Q.Tool.from(qFilterTool, "Q/filter") : null;

		// if Q/filter didn't created - create one
		if (!qFilterTool) {
			$te.tool('Q/filter', {
				placeholder: state.text.areas.filterPlaceholder
			}, 'Q_filter')
			.appendTo(tool.element)
			.activate(function(){
				qFilterTool = Q.Tool.from(this.element, "Q/filter");
				
				// filtering Streams/related tool results
				qFilterTool.state.onFilter.set(function (query, element) {
					var titles = qFilterTool.$(".Streams_related_tool .Streams_preview_tool").not(".Streams_preview_composer");

					titles.each(function(){
						var $this = $(this);

						// if title start with query string - show Streams/preview tool element, and hide otherwise
						if ($(".Streams_preview_title", $this).text().toUpperCase().startsWith(query.toUpperCase())) {
							$this.show();
						} else {
							$this.hide();
						}
					});
				}, tool);

				// set selected Places/area stream
				qFilterTool.state.onChoose.set(function (element, details) {
					var previewTool = Q.Tool.from($(element).closest(".Streams_preview_tool"), "Streams/preview");

					state.areaSelected = {
						publisherId: previewTool.state.publisherId,
						streamName: previewTool.state.streamName,
						text: details.text
					};
				}, tool);

				// clear selected Places/area stream
				qFilterTool.state.onClear.set(function () {
					state.areaSelected = null;
				}, tool);
			});
		}

		var relatedTool = Q.Tool.from(tool.$(".Q_filter_results"), "Streams/related");
		tool.getStream(function(stream){
			// if related tool already exist - set new stream and refresh
			if (relatedTool) {
				relatedTool.state.publisherId = stream.fields.publisherId;
				relatedTool.state.streamName = stream.fields.name;
				relatedTool.refresh();

				return;
			}

			// apply Streams/related tool exactly to Q/filter results element
			tool.$(".Q_filter_results").tool("Streams/related", {
				publisherId: stream.fields.publisherId,
				streamName: stream.fields.name,
				relationType: 'area',
				isCategory: true,
				editable: false,
				onRefresh: function(){
					// add Q_filter_result class to each preview tool except composer
					$(".Streams_preview_container", $(".Streams_preview_tool", this.element).not(".Streams_preview_composer")).addClass("Q_filter_result");
				},
				creatable: {
					"Places/area": {
						'title': state.text.areas.newArea,
						'preprocess': function(_proceed){
							var previewTool = this;
							var title = qFilterTool.$input.val();

							tool.prompt(title, relatedTool, _proceed);
						}
					}
				}
			}).activate(function(){
				relatedTool = this;
			});
		});
	},
	/**
	 * Show Q.prompt to add new area
	 * @method prompt
	 * @param {string} [title] default area name
	 * @param {Q.Tool} relatedTool Streams/related tool with areas related to Places/location stream
	 * @param {function} _proceed Callback from Streams/related tool to create new stream
	 */
	prompt: function(title, relatedTool, _proceed){
		var tool = this;
		var state = this.state;

		title = title || "";

		var $prompt = Q.prompt(state.text.areas.promptTitle, function (title, dialog) {
			// user click cancel button
			if (title === null) {
				return false;
			}

			// title required
			if (!title) {
				Q.alert(state.text.areas.absent, {
					title: state.text.areas.error,
					onClose: function(){
						tool.prompt(title, relatedTool, _proceed);
					}
				});
				return false;
			}

			// get array of areas exist
			var areasExist = relatedTool.$(".Streams_preview_title").map(function(){
				return $.trim($(this).text());
			}).get();

			// if title already exist
			if ($.inArray(title, areasExist) >= 0) {
				Q.alert(state.text.areas.exist, {
					title: state.text.areas.error,
					onClose: function(){
						tool.prompt(title, relatedTool, _proceed);
					}
				});
				return false;
			}

			Q.handle(_proceed, this, [{title: title}]);

			// wait when new preview tool created with this title and add class Q_filter_result
			var timerId = setInterval(function(){
				var container = relatedTool.$(".Streams_preview_container .Streams_preview_title:contains('"+title+"')");

				if(!container.length){
					return;
				}

				clearInterval(timerId);

				container.closest(".Streams_preview_container").addClass("Q_filter_result")
			}, 500);
		},
		{
			title: state.text.areas.addNewArea,
			ok: state.text.areas.add
		});

		// set default value
		$("input[type=text]", $prompt).val(title);
	},
	/**
	 * Get location stream and launch callback with this stream as argument
	 * @method getStream
	 * @param {Function} [callback] callback
	 */
	getStream: function(callback){
		var state = this.state;

		// set communityId as publisherId if last empty
		state.publisherId = state.publisherId || Q.info.appId;

		if (!state.stream && (state.publisherId && state.streamName)) {
			state.stream = {
				publisherId: state.publisherId,
				name: state.streamName,
				stripped: true
			};
		}

		var location = state.location;

		// required publisherId and streamName OR location
		if (!state.stream && !location) {
			throw new Exception("Places/areas: required publisherId and streamName OR location");
		}

		if (state.stream && state.stream.stripped) { // stripped stream means that it have only publisherId and name
			Q.Streams.get(state.stream.publisherId, state.stream.name, function () {
				Q.handle(callback, this, [this]);
			});
		} else if(state.stream) { // we have pure stream
			Q.handle(callback, state.stream, [state.stream]);
		} else if(location) { // we have just location object and need to check whether stream exist
			// check if we already have location with lat, lng and use one
			// if no - create Places/location stream
			Q.req("Places/areas", 'data', function (err, response) {
				var msg;
				if (msg = Q.firstErrorMessage(err, response && response.errors)) {
					console.warn("Places/areas: " + msg);
					return false;
				}

				var stream = response.slots.data;
				Q.Streams.get(stream.publisherId, stream.name, function () {
					Q.handle(callback, this, [this]);
				});
			}, {
				method: 'GET',
				fields: {
					location: {
						latitude: location.latitude,
						longitude: location.longitude,
						venue: location.venue,
						placeId: location.placeId
					}
				}
			});
		}
	}
});

})(Q, jQuery, window, document);