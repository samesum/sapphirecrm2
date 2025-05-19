(function($) {
	$.fn.DualSelectList = function(parameter) {
		// Only allow DIV to be the DualSelectList container
		if (this.length !== 1 || this.prop('tagName') !== 'DIV') return this;

		// Constants
		const CONST_LEFT = 1;
		const CONST_RIGHT = 2;
		const CONST_BOTH = 3;
		const CONST_FILTER_PLACEHOLDER = 'Input Filter';

		// Default parameters
		const defaults = {
			candidateItems: [],
			selectionItems: [],
			colors: {
				panelBackground: '',
				filterText: '',
				itemText: '',
				itemBackground: '',
				itemHoverBackground: '',
				itemPlaceholderBackground: '',
				itemPlaceholderBorder: ''
			}
		};
		
		const params = $.extend(true, {}, defaults, parameter);

		// Private variables
		let thisMain = this;
		let thisMainID = '_dsl_' + Date.now();
		const thisPanel = { left: null, right: null };
		const thisInput = { left: null, right: null };
		const thisMover = { left: null, right: null };
		let thisItemNull = null;

		let thisSelect = null;
		let srcEvent = null;
		let isPickup = false;
		let isMoving = false;
		let xOffset = null;
		let yOffset = null;

		const thisCandidateItems = [];
		const thisSelectionItems = [];

		// Initialize the plugin
		thisMain.attr('id', thisMainID);
		
		// Initialize DualSelectList content
		thisMain.append(`
			<div class="dsl-filter left-panel">
				<input class="dsl-filter-input" type="text" value="${CONST_FILTER_PLACEHOLDER}" />
				<div class="dsl-filter-move-all left-panel">&#x25B6;</div>
			</div>
			<div class="dsl-filter right-panel">
				<input class="dsl-filter-input" type="text" value="${CONST_FILTER_PLACEHOLDER}" />
				<div class="dsl-filter-move-all right-panel">&#x25C0;</div>
			</div>
			<div class="dsl-panel left-panel"></div>
			<div class="dsl-panel right-panel"></div>
			<div class="dsl-panel-item-null">&nbsp;</div>
		`);

		// Cache jQuery objects
		thisPanel.left = thisMain.find('div.dsl-panel.left-panel').eq(0);
		thisPanel.right = thisMain.find('div.dsl-panel.right-panel').eq(0);
		thisInput.left = thisMain.find('div.dsl-filter.left-panel input.dsl-filter-input').eq(0);
		thisInput.right = thisMain.find('div.dsl-filter.right-panel input.dsl-filter-input').eq(0);
		thisMover.left = thisMain.find('div.dsl-filter-move-all.left-panel').eq(0);
		thisMover.right = thisMain.find('div.dsl-filter-move-all.right-panel').eq(0);
		thisItemNull = thisMain.find('div.dsl-panel-item-null');

		// Process initial items
		if (!Array.isArray(params.candidateItems)) {
			params.candidateItems = [{ value: params.candidateItems }];
		}
		
		if (params.candidateItems.length > 0) {
			params.candidateItems.forEach((item, index) => {
				if (item.value === undefined) item = { value: item };
				const thisIdx = thisCandidateItems.push(item) - 1;
				const itemString = $.trim(item.value.toString());
				if (itemString !== '') {
					thisPanel.left.append(`<div class="dsl-panel-item" dlid="c${thisIdx}">${itemString}</div>`);
				}
			});
		}

		if (!Array.isArray(params.selectionItems)) {
			params.selectionItems = [{ value: params.selectionItems }];
		}
		
		if (params.selectionItems.length > 0) {
			params.selectionItems.forEach((item, index) => {
				if (item.value === undefined) item = { value: item };
				const thisIdx = thisSelectionItems.push(item) - 1;
				const itemString = $.trim(item.value.toString());
				if (itemString !== '') {
					thisPanel.right.append(`<div class="dsl-panel-item" dlid="s${thisIdx}">${itemString}</div>`);
				}
			});
		}

		// Initial UI setup
		toggleMoveAllIcon(CONST_BOTH);
		toggleItemDisplay(CONST_BOTH);

		// Set up event handlers
		$(document)
			.on('mousedown', `#${thisMainID} div.dsl-panel-item`, function(event) {
				thisMain.find('div.dsl-panel-item:animated').stop(false, true);
				thisSelect = $(this);
				isPickup = true;
				srcEvent = event;
				event.preventDefault();
			})
			.on('mousemove', 'body', function(event) {
				if (!isPickup) return;

				if (isMoving) {
					thisSelect.css({
						left: event.pageX + xOffset,
						top: event.pageY + yOffset
					});

					const target = findItemLocation(thisSelect);
					updatePlaceholderPosition(target);
				} else {
					if (Math.abs(event.pageX - srcEvent.pageX) >= 2 || 
						Math.abs(event.pageY - srcEvent.pageY) >= 2) {
						isMoving = true;
						const srcPanel = thisSelect.parent('div.dsl-panel');
						xOffset = thisSelect.position().left - event.pageX;
						yOffset = thisSelect.position().top - event.pageY;
						thisSelect.css({
							position: 'absolute',
							'z-index': 10,
							left: thisSelect.position().left,
							top: thisSelect.position().top,
							width: srcPanel.width()
						}).appendTo(thisMain);
					}
				}
				event.preventDefault();
			})
			.on('mouseup', `#${thisMainID} div.dsl-panel-item`, function(event) {
				if (!isPickup) return;

				if (!isMoving) {
					moveItemToOtherPanel();
				} else {
					const target = findItemLocation(thisSelect);
					placeItem(target);
				}

				cleanupAfterDrop();
				event.preventDefault();
			})
			.on('keyup', function(event) {
				if (isPickup && isMoving && event.key === 'Escape') {
					const target = findItemLocation(thisSelect);
					placeItem(target);
					cleanupAfterDrop();
				}
			});

		$(document)
			.on('focus', `#${thisMainID} input.dsl-filter-input`, function() {
				if ($(this).val() === CONST_FILTER_PLACEHOLDER) {
					$(this).val('').css({
						'font-weight': 'normal',
						'font-style': 'normal',
						color: 'black'
					});
				}
			})
			.on('focusout', `#${thisMainID} input.dsl-filter-input`, function() {
				if ($(this).val() === '') {
					$(this).val(CONST_FILTER_PLACEHOLDER).css({
						'font-weight': 'bolder',
						'font-style': 'Italic',
						color: 'lightgray'
					});
				}
			})
			.on('keyup', `#${thisMainID} input.dsl-filter-input`, function() {
				toggleMoveAllIcon(CONST_BOTH);
				toggleItemDisplay(CONST_BOTH);
			});

		$(`#${thisMainID} div.dsl-filter-move-all`).on('click', function() {
			const tarPanel = $(this).hasClass('left-panel') ? thisPanel.left : thisPanel.right;
			tarPanel.find('div.dsl-panel-item:visible').each(function() {
				$(this).trigger('mousedown').trigger('mouseup');
			});
			toggleMoveAllIcon(CONST_BOTH);
			toggleItemDisplay(CONST_BOTH);
		});

		// Helper functions
		function findItemLocation(objItem) {
			const target = {
				targetPanel: null,
				targetItem: null,
				targetFirstPosition: false
			};

			target.targetPanel = objItem.position().left <= (thisPanel.left.position().left + (0.5 * thisPanel.left.width())) ? 
				thisPanel.left : thisPanel.right;

			const candidateItems = target.targetPanel.find('div.dsl-panel-item');
			for (let n = 0; n < candidateItems.length; n++) {
				if (objItem.position().top > candidateItems.eq(n).position().top) {
					target.targetItem = candidateItems[n];
				} else if (objItem.position().top <= candidateItems.eq(n).position().top && n === 0) {
					target.targetFirstPosition = true;
				}
			}

			return target;
		}

		function toggleMoveAllIcon(target) {
			if (target & CONST_LEFT) {
				const lftItems = thisPanel.left.find('div.dsl-panel-item:visible');
				lftItems.length > 0 ? thisMover.left.show() : thisMover.left.hide();
			}
			if (target & CONST_RIGHT) {
				const rgtItems = thisPanel.right.find('div.dsl-panel-item:visible');
				rgtItems.length > 0 ? thisMover.right.show() : thisMover.right.hide();
			}
		}

		function toggleItemDisplay(target) {
			if (target & CONST_LEFT) {
				let lftFilterText = thisInput.left.val();
				if (lftFilterText === CONST_FILTER_PLACEHOLDER) lftFilterText = '';
				thisPanel.left.find('div.dsl-panel-item').show();
				if (lftFilterText !== '') {
					thisPanel.left.find('div.dsl-panel-item:not(:contains(' + lftFilterText + '))').hide();
				}
			}
			if (target & CONST_RIGHT) {
				let rgtFilterText = thisInput.right.val();
				if (rgtFilterText === CONST_FILTER_PLACEHOLDER) rgtFilterText = '';
				thisPanel.right.find('div.dsl-panel-item').show();
				if (rgtFilterText !== '') {
					thisPanel.right.find('div.dsl-panel-item:not(:contains(' + rgtFilterText + '))').hide();
				}
			}
		}

		function moveItemToOtherPanel() {
			const srcPanel = thisSelect.parent('div.dsl-panel');
			const tarPanel = srcPanel.siblings('div.dsl-panel');
			const tarItem = tarPanel.find('div.dsl-panel-item:visible:last');

			const xSrc = thisSelect.position().left;
			const ySrc = thisSelect.position().top;
			let xTar = 0;
			let yTar = 0;

			if (tarItem.length > 0) {
				xTar = tarItem.position().left;
				yTar = tarItem.position().top + tarItem.height();
				yTar = Math.min(yTar, tarPanel.position().top + tarPanel.width());
			} else {
				xTar = tarPanel.position().left;
				yTar = tarPanel.position().top;
			}

			thisSelect.css({
				'pointer-events': 'none',
				position: 'absolute',
				'z-index': 10,
				left: xSrc,
				top: ySrc,
				width: srcPanel.width()
			}).animate({
				left: xTar,
				top: yTar
			}, 200, () => {
				thisSelect.css({
					'pointer-events': 'initial',
					position: 'initial',
					'z-index': 'initial',
					width: 'calc(100% - 16px)'
				}).appendTo(tarPanel);
				toggleMoveAllIcon(CONST_BOTH);
				toggleItemDisplay(CONST_BOTH);
			});
		}

		function placeItem(target) {
			if (target.targetFirstPosition) {
				thisSelect.css({
					position: 'initial',
					'z-index': 'initial',
					width: 'calc(100% - 16px)'
				}).prependTo(target.targetPanel);
			} else if (target.targetItem === null) {
				thisSelect.css({
					position: 'initial',
					'z-index': 'initial',
					width: 'calc(100% - 16px)'
				}).appendTo(target.targetPanel);
			} else {
				thisSelect.css({
					position: 'initial',
					'z-index': 'initial',
					width: 'calc(100% - 16px)'
				}).insertAfter(target.targetItem);
			}
		}

		function cleanupAfterDrop() {
			isPickup = false;
			isMoving = false;
			thisItemNull.appendTo(thisMain).hide();
			toggleMoveAllIcon(CONST_BOTH);
			toggleItemDisplay(CONST_BOTH);
		}

		function updatePlaceholderPosition(target) {
			if (target.targetFirstPosition) {
				thisItemNull.prependTo(target.targetPanel).show();
			} else if (target.targetItem === null) {
				thisItemNull.appendTo(target.targetPanel).show();
			} else {
				thisItemNull.insertAfter(target.targetItem).show();
			}
		}

		// Expose public methods
		thisMain.setCandidate = function(candidate) {
			if (!Array.isArray(candidate)) {
				candidate = [{ value: candidate }];
			}

			candidate.forEach((item, index) => {
				if (item.value === undefined) item = { value: item };
				const thisIdx = thisCandidateItems.push(item) - 1;
				const itemString = $.trim(item.value.toString());
				if (itemString !== '') {
					thisPanel.left.append(`<div class="dsl-panel-item" dlid="c${thisIdx}">${itemString}</div>`);
				}
			});
		};

		thisMain.setSelection = function(selection) {
			if (!Array.isArray(selection)) {
				selection = [{ value: selection }];
			}

			selection.forEach((item, index) => {
				if (item.value === undefined) item = { value: item };
				const thisIdx = thisSelectionItems.push(item) - 1;
				const itemString = $.trim(item.value.toString());
				if (itemString !== '') {
					thisPanel.right.append(`<div class="dsl-panel-item" dlid="s${thisIdx}">${itemString}</div>`);
				}
			});
		};

		thisMain.getSelection = function(stringOnly = false) {
			const result = [];
			const selection = thisPanel.right.find('div.dsl-panel-item');
			selection.each(function() {
				if (stringOnly) {
					result.push($(this).text());
				} else {
					const thisIdx = $(this).attr('dlid');
					if (thisIdx.startsWith('c')) {
						const idx = parseInt(thisIdx.substring(1), 10);
						result.push(thisCandidateItems[idx]);
					} else {
						const idx = parseInt(thisIdx.substring(1), 10);
						result.push(thisSelectionItems[idx]);
					}
				}
			});
			return result;
		};

		thisMain.setColor = function(clsName, clrString) {
			clsName = $.trim(clsName);
			clrString = $.trim(clrString);
			if (!clrString) return;

			const colorProperties = {
				panelBackground: 'panelBackground',
				filterText: 'filterText',
				itemText: 'itemText',
				itemBackground: 'itemBackground',
				itemHoverBackground: 'itemHoverBackground',
				itemPlaceholderBackground: 'itemPlaceholderBackground',
				itemPlaceholderBorder: 'itemPlaceholderBorder'
			};

			if (colorProperties[clsName]) {
				params.colors[colorProperties[clsName]] = clrString;
				const cssContent = `${colorProperties[clsName] ? `.${colorProperties[clsName]} {${clsName}: ${clrString} !important;}` : ''}`;
				$('#dual-select-list-style').remove();
				if (cssContent) $('head').append($('<style id="dual-select-list-style"></style>').text(cssContent));
			}
		};

		thisMain.resetColor = function(clsName) {
			clsName = $.trim(clsName);
			if (clsName === '') {
				params.colors = $.extend(true, {}, $.fn.DualSelectList.defaults.colors);
			} else {
				const colorProperties = {
					panelBackground: 'panelBackground',
					filterText: 'filterText',
					itemText: 'itemText',
					itemBackground: 'itemBackground',
					itemHoverBackground: 'itemHoverBackground',
					itemPlaceholderBackground: 'itemPlaceholderBackground',
					itemPlaceholderBorder: 'itemPlaceholderBorder'
				};
				if (colorProperties[clsName]) {
					params.colors[colorProperties[clsName]] = '';
				}
			}
			$('#dual-select-list-style').remove();
		};

		return thisMain;
	};

	// Default settings
	$.fn.DualSelectList.defaults = {
		candidateItems: [],
		selectionItems: [],
		colors: {
			panelBackground: '',
			filterText: '',
			itemText: '',
			itemBackground: '',
			itemHoverBackground: '',
			itemPlaceholderBackground: '',
			itemPlaceholderBorder: ''
		}
	};
})(jQuery);
