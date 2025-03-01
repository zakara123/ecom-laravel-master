// File#: _1_filter
// Usage: codyhouse.co/license

(function() {
    var Filter = function(opts) {
      this.options = Util.extend(Filter.defaults , opts); // used to store custom filter/sort functions
      this.element = this.options.element;
      this.elementId = this.element.getAttribute('id');
      this.items = this.element.querySelectorAll('.js-filter__item');
      this.controllers = document.querySelectorAll('[aria-controls="'+this.elementId+'"]'); // controllers wrappers
      this.fallbackMessage = document.querySelector('[data-fallback-gallery-id="'+this.elementId+'"]');
      this.filterString = []; // combination of different filter values
      this.sortingString = '';  // sort value - will include order and type of argument (e.g., number or string)
      // store info about sorted/filtered items
      this.filterList = []; // list of boolean for each this.item -> true if still visible , otherwise false
      this.sortingList = []; // list of new ordered this.item -> each element is [item, originalIndex]
      
      // store grid info for animation
      this.itemsGrid = []; // grid coordinates
      this.itemsInitPosition = []; // used to store coordinates of this.items before animation
      this.itemsIterPosition = []; // used to store coordinates of this.items before animation - intermediate state
      this.itemsFinalPosition = []; // used to store coordinates of this.items after filtering
      
      // animation off
      this.animateOff = this.element.getAttribute('data-filter-animation') == 'off';
      // used to update this.itemsGrid on resize
      this.resizingId = false;
      // default acceleration style - improve animation
      this.accelerateStyle = 'will-change: transform, opacity; transform: translateZ(0); backface-visibility: hidden;';
  
      // handle multiple changes
      this.animating = false;
      this.reanimate = false;
  
      initFilter(this);
    };
  
    function initFilter(filter) {
      resetFilterSortArray(filter, true, true); // init array filter.filterList/filter.sortingList
      createGridInfo(filter); // store grid coordinates in filter.itemsGrid
      initItemsOrder(filter); // add data-orders so that we can reset the sorting
  
      // events handling - filter update
      for(var i = 0; i < filter.controllers.length; i++) {
        filter.filterString[i] = ''; // reset filtering

        // get proper filter/sorting string based on selected controllers
        (function(i){
          filter.controllers[i].addEventListener('change', function(event) {  
            if(event.target.tagName.toLowerCase() == 'select') { // select elements
              (!event.target.getAttribute('data-filter'))
                ? setSortingString(filter, event.target.value, event.target.options[event.target.selectedIndex])
                : setFilterString(filter, i, 'select');
            } else if(event.target.tagName.toLowerCase() == 'input' && (event.target.getAttribute('type') == 'radio' || event.target.getAttribute('type') == 'checkbox') ) { // input (radio/checkboxed) elements
              (!event.target.getAttribute('data-filter'))
                ? setSortingString(filter, event.target.getAttribute('data-sort'), event.target)
                : setFilterString(filter, i, 'input');
            } else {
              // generic inout element
              (!filter.controllers[i].getAttribute('data-filter'))
                ? setSortingString(filter, filter.controllers[i].getAttribute('data-sort'), filter.controllers[i])
                : setFilterString(filter, i, 'custom');
            }
  
            updateFilterArray(filter);
          });
  
          filter.controllers[i].addEventListener('click', function(event) { // retunr if target is select/input elements
            var filterEl = event.target.closest('[data-filter]');
            var sortEl = event.target.closest('[data-sort]');
            if(!filterEl && !sortEl) return;
            if(filterEl && ( filterEl.tagName.toLowerCase() == 'input' || filterEl.tagName.toLowerCase() == 'select')) return;
            if(sortEl && (sortEl.tagName.toLowerCase() == 'input' || sortEl.tagName.toLowerCase() == 'select')) return;
            if(sortEl && Util.hasClass(sortEl, 'js-filter__custom-control')) return;
            if(filterEl && Util.hasClass(filterEl, 'js-filter__custom-control')) return;
            // this will be executed only for a list of buttons -> no inputs
            event.preventDefault();
            resetControllersList(filter, i, filterEl, sortEl);
            sortEl 
              ? setSortingString(filter, sortEl.getAttribute('data-sort'), sortEl)
              : setFilterString(filter, i, 'button');
            updateFilterArray(filter);
          });
  
          // target search inputs -> update them on 'input'
          filter.controllers[i].addEventListener('input', function(event) {
            if(event.target.tagName.toLowerCase() == 'input' && (event.target.getAttribute('type') == 'search' || event.target.getAttribute('type') == 'text') ) {
              setFilterString(filter, i, 'custom');
              updateFilterArray(filter);
            }
          });
        })(i);
      }
  
      // handle resize - update grid coordinates in filter.itemsGrid
      window.addEventListener('resize', function() {
        clearTimeout(filter.resizingId);
        filter.resizingId = setTimeout(function(){createGridInfo(filter)}, 300);
      });
  
      // check if there are filters/sorting values already set
      checkInitialFiltering(filter);
  
      // reset filtering results if filter selection was changed by an external control (e.g., form reset) 
      filter.element.addEventListener('update-filter-results', function(event){
        // reset filters first
        for(var i = 0; i < filter.controllers.length; i++) filter.filterString[i] = '';
        filter.sortingString = '';
        checkInitialFiltering(filter);
      });
    };
  
    function checkInitialFiltering(filter) {
      for(var i = 0; i < filter.controllers.length; i++) { // check if there's a selected option
        // buttons list
        var selectedButton = filter.controllers[i].getElementsByClassName('js-filter-selected');
        if(selectedButton.length > 0) {
          var sort = selectedButton[0].getAttribute('data-sort');
          sort
            ? setSortingString(filter, selectedButton[0].getAttribute('data-sort'), selectedButton[0])
            : setFilterString(filter, i, 'button');
          continue;
        }
  
        // input list
        var selectedInput = filter.controllers[i].querySelectorAll('input:checked');
        if(selectedInput.length > 0) {
          var sort = selectedInput[0].getAttribute('data-sort');
          sort
            ? setSortingString(filter, sort, selectedInput[0])
            : setFilterString(filter, i, 'input');
          continue;
        }
        // select item
        if(filter.controllers[i].tagName.toLowerCase() == 'select') {
          var sort = filter.controllers[i].getAttribute('data-sort');
          sort
            ? setSortingString(filter, filter.controllers[i].value, filter.controllers[i].options[filter.controllers[i].selectedIndex])
            : setFilterString(filter, i, 'select');
           continue;
        }
        // check if there's a generic custom input
        var radioInput = filter.controllers[i].querySelector('input[type="radio"]'),
          checkboxInput = filter.controllers[i].querySelector('input[type="checkbox"]');
        if(!radioInput && !checkboxInput) {
          var sort = filter.controllers[i].getAttribute('data-sort');
          var filterString = filter.controllers[i].getAttribute('data-filter');
          if(sort) setSortingString(filter, sort, filter.controllers[i]);
          else if(filterString) setFilterString(filter, i, 'custom');
        }
      }
  
      updateFilterArray(filter);
    };
  
    function setSortingString(filter, value, item) {
      // get sorting string value-> sortName:order:type
      var order = item.getAttribute('data-sort-order') ? 'desc' : 'asc';
      var type = item.getAttribute('data-sort-number') ? 'number' : 'string';
      filter.sortingString = value+':'+order+':'+type;
    };
  
    function setFilterString(filter, index, type) {
      // get filtering array -> [filter1:filter2, filter3, filter4:filter5]
      if(type == 'input') {
        var checkedInputs = filter.controllers[index].querySelectorAll('input:checked');
        filter.filterString[index] = '';
        for(var i = 0; i < checkedInputs.length; i++) {
          filter.filterString[index] = filter.filterString[index] + checkedInputs[i].getAttribute('data-filter') + ':';
        }
      } else if(type == 'select') {
        if(filter.controllers[index].multiple) { // select with multiple options
          filter.filterString[index] = getMultipleSelectValues(filter.controllers[index]);
        } else { // select with single option
          filter.filterString[index] = filter.controllers[index].value;
        }
      } else if(type == 'button') {
        var selectedButtons = filter.controllers[index].querySelectorAll('.js-filter-selected');
        filter.filterString[index] = '';
        for(var i = 0; i < selectedButtons.length; i++) {
          filter.filterString[index] = filter.filterString[index] + selectedButtons[i].getAttribute('data-filter') + ':';
        }
      } else if(type == 'custom') {
        filter.filterString[index] = filter.controllers[index].getAttribute('data-filter');
      }
    };
  
    function resetControllersList(filter, index, target1, target2) {
      // for a <button>s list -> toggle js-filter-selected + custom classes
      var multi = filter.controllers[index].getAttribute('data-filter-checkbox'),
        customClass = filter.controllers[index].getAttribute('data-selected-class');
      
      customClass = (customClass) ? 'js-filter-selected '+ customClass : 'js-filter-selected';
      if(multi == 'true') { // multiple options can be on
        (target1) 
          ? Util.toggleClass(target1, customClass, !Util.hasClass(target1, 'js-filter-selected'))
          : Util.toggleClass(target2, customClass, !Util.hasClass(target2, 'js-filter-selected'));
      } else { // only one element at the time
        // remove the class from all siblings
        var selectedOption = filter.controllers[index].querySelector('.js-filter-selected');
        if(selectedOption) Util.removeClass(selectedOption, customClass);
        (target1) 
          ? Util.addClass(target1, customClass)
          : Util.addClass(target2, customClass);
      }
    };
  
    function updateFilterArray(filter) { // sort/filter strings have been updated -> so you can update the gallery
      if(filter.animating) {
        filter.reanimate = true;
        return;
      }
      filter.animating = true;
      filter.reanimate = false;
      createGridInfo(filter); // get new grid coordinates
      sortingGallery(filter); // update sorting list 
      filteringGallery(filter); // update filter list
      resetFallbackMessage(filter, true); // toggle fallback message
      if(reducedMotion || filter.animateOff) {
        resetItems(filter);
      } else {
        updateItemsAttributes(filter);
      }
    };
  
    function sortingGallery(filter) {
      // use sorting string to reorder gallery
      var sortOptions = filter.sortingString.split(':');
      if(sortOptions[0] == '' || sortOptions[0] == '*') {
        // no sorting needed
        restoreSortOrder(filter);
      } else { // need to sort
        if(filter.options[sortOptions[0]]) { // custom sort function -> user takes care of it
          filter.sortingList = filter.options[sortOptions[0]](filter.sortingList);
        } else {
          filter.sortingList.sort(function(left, right) {
            var leftVal = left[0].getAttribute('data-sort-'+sortOptions[0]),
            rightVal = right[0].getAttribute('data-sort-'+sortOptions[0]);
            if(sortOptions[2] == 'number') {
              leftVal = parseFloat(leftVal);
              rightVal = parseFloat(rightVal);
            }
            if(sortOptions[1] == 'desc') return leftVal <= rightVal ? 1 : -1;
            else return leftVal >= rightVal ? 1 : -1;
          });
        }
      }
    };
  
    function filteringGallery(filter) {
      // use filtering string to reorder gallery
      resetFilterSortArray(filter, true, false);
      // we can have multiple filters
      for(var i = 0; i < filter.filterString.length; i++) {
        //check if multiple filters inside the same controller
        if(filter.filterString[i] != '' && filter.filterString[i] != '*' && filter.filterString[i] != ' ') {
          singleFilterGallery(filter, filter.filterString[i].split(':'));
        }
      }
    };
  
    function singleFilterGallery(filter, subfilter) {
      if(!subfilter || subfilter == '' || subfilter == '*') return;
      // check if we have custom options
      var customFilterArray = [];
      for(var j = 0; j < subfilter.length; j++) {
        if(filter.options[subfilter[j]]) { // custom function
          customFilterArray[subfilter[j]] = filter.options[subfilter[j]](filter.items);
        }
      }
  
      for(var i = 0; i < filter.items.length; i++) {
        var filterValues = filter.items[i].getAttribute('data-filter').split(' ');
        var present = false;
        for(var j = 0; j < subfilter.length; j++) {
          if(filter.options[subfilter[j]] && customFilterArray[subfilter[j]][i]) { // custom function
            present = true;
            break;
          } else if(subfilter[j] == '*' || filterValues.indexOf(subfilter[j]) > -1) {
            present = true;
            break;
          }
        }
        filter.filterList[i] = !present ? false : filter.filterList[i];
      }
    };
  
    function updateItemsAttributes(filter) { // set items before triggering the update animation
      // get offset of all elements before animation
      storeOffset(filter, filter.itemsInitPosition);
      // set height of container
      filter.element.setAttribute('style', 'height: '+parseFloat(filter.element.offsetHeight)+'px; width: '+parseFloat(filter.element.offsetWidth)+'px;');
  
      for(var i = 0; i < filter.items.length; i++) { // remove is-hidden class from items now visible and scale to zero
        if( Util.hasClass(filter.items[i], 'is-hidden') && filter.filterList[i]) {
          filter.items[i].setAttribute('data-scale', 'on');
          filter.items[i].setAttribute('style', filter.accelerateStyle+'transform: scale(0.5); opacity: 0;')
          Util.removeClass(filter.items[i], 'is-hidden');
        }
      }
      // get new elements offset
      storeOffset(filter, filter.itemsIterPosition);
      // translate items so that they are in the right initial position
      for(var i = 0; i < filter.items.length; i++) {
        if( filter.items[i].getAttribute('data-scale') != 'on') {
          filter.items[i].setAttribute('style', filter.accelerateStyle+'transform: translateX('+parseInt(filter.itemsInitPosition[i][0] - filter.itemsIterPosition[i][0])+'px) translateY('+parseInt(filter.itemsInitPosition[i][1] - filter.itemsIterPosition[i][1])+'px);');
        }
      }
  
      animateItems(filter)
    };
  
    function animateItems(filter) {
      var transitionValue = 'transform '+filter.options.duration+'ms cubic-bezier(0.455, 0.03, 0.515, 0.955), opacity '+filter.options.duration+'ms';
  
      // get new index of items in the list
      var j = 0;
      for(var i = 0; i < filter.sortingList.length; i++) {
        var item = filter.items[filter.sortingList[i][1]];
          
        if(Util.hasClass(item, 'is-hidden') || !filter.filterList[filter.sortingList[i][1]]) {
          // item is hidden or was previously hidden -> final position equal to first one
          filter.itemsFinalPosition[filter.sortingList[i][1]] = filter.itemsIterPosition[filter.sortingList[i][1]];
          if(item.getAttribute('data-scale') == 'on') j = j + 1; 
        } else {
          filter.itemsFinalPosition[filter.sortingList[i][1]] = [filter.itemsGrid[j][0], filter.itemsGrid[j][1]]; // left/top
          j = j + 1; 
        }
      } 
  
      setTimeout(function(){
        for(var i = 0; i < filter.items.length; i++) {
          if(filter.filterList[i] && filter.items[i].getAttribute('data-scale') == 'on') { // scale up item
            filter.items[i].setAttribute('style', filter.accelerateStyle+'transition: '+transitionValue+'; transform: translateX('+parseInt(filter.itemsFinalPosition[i][0] - filter.itemsIterPosition[i][0])+'px) translateY('+parseInt(filter.itemsFinalPosition[i][1] - filter.itemsIterPosition[i][1])+'px) scale(1); opacity: 1;');
          } else if(filter.filterList[i]) { // translate item
            filter.items[i].setAttribute('style', filter.accelerateStyle+'transition: '+transitionValue+'; transform: translateX('+parseInt(filter.itemsFinalPosition[i][0] - filter.itemsIterPosition[i][0])+'px) translateY('+parseInt(filter.itemsFinalPosition[i][1] - filter.itemsIterPosition[i][1])+'px);');
          } else { // scale down item
            filter.items[i].setAttribute('style', filter.accelerateStyle+'transition: '+transitionValue+'; transform: scale(0.5); opacity: 0;');
          }
        };
      }, 50);  
      
      // wait for the end of transition of visible elements
      setTimeout(function(){
        resetItems(filter);
      }, (filter.options.duration + 100));
    };
  
    function resetItems(filter) {
      // animation was off or animation is over -> reset attributes
      for(var i = 0; i < filter.items.length; i++) {
        filter.items[i].removeAttribute('style');
        Util.toggleClass(filter.items[i], 'is-hidden', !filter.filterList[i]);
        filter.items[i].removeAttribute('data-scale');
      }
      
      for(var i = 0; i < filter.items.length; i++) {// reorder
        filter.element.appendChild(filter.items[filter.sortingList[i][1]]);
      }
  
      filter.items = [];
      filter.items = filter.element.querySelectorAll('.js-filter__item');
      resetFilterSortArray(filter, false, true);
      filter.element.removeAttribute('style');
      filter.animating = false;
      if(filter.reanimate) {
        updateFilterArray(filter);
      }
  
      resetFallbackMessage(filter, false); // toggle fallback message
  
      // emit custom event - end of filtering
      filter.element.dispatchEvent(new CustomEvent('filter-selection-updated'));
    };
  
    function resetFilterSortArray(filter, filtering, sorting) {
      for(var i = 0; i < filter.items.length; i++) {
        if(filtering) filter.filterList[i] = true;
        if(sorting) filter.sortingList[i] = [filter.items[i], i];
      }
    };
  
    function createGridInfo(filter) {
      var containerWidth = parseFloat(window.getComputedStyle(filter.element).getPropertyValue('width')),
        itemStyle, itemWidth, itemHeight, marginX, marginY, colNumber;
  
      // get offset first visible element
      for(var i = 0; i < filter.items.length; i++) {
        if( !Util.hasClass(filter.items[i], 'is-hidden') ) {
          itemStyle = window.getComputedStyle(filter.items[i]),
          itemWidth = parseFloat(itemStyle.getPropertyValue('width')),
          itemHeight = parseFloat(itemStyle.getPropertyValue('height')),
          marginX = parseFloat(itemStyle.getPropertyValue('margin-left')) + parseFloat(itemStyle.getPropertyValue('margin-right')),
          marginY = parseFloat(itemStyle.getPropertyValue('margin-bottom')) + parseFloat(itemStyle.getPropertyValue('margin-top'));
          if(marginX == 0 && marginY == 0) {
            // grid is set using the gap property and not margins
            var margins = resetMarginValues(filter);
            marginX = margins[0];
            marginY = margins[1];
          }
          var colNumber = parseInt((containerWidth + marginX)/(itemWidth+marginX));
          filter.itemsGrid[0] = [filter.items[i].offsetLeft, filter.items[i].offsetTop]; // left, top
          break;
        }
      }
  
      for(var i = 1; i < filter.items.length; i++) {
        var x = i < colNumber ? i : i % colNumber,
          y = i < colNumber ? 0 : Math.floor(i/colNumber);
        filter.itemsGrid[i] = [filter.itemsGrid[0][0] + x*(itemWidth+marginX), filter.itemsGrid[0][1] + y*(itemHeight+marginY)];
      }
    };
  
    function storeOffset(filter, array) {
      for(var i = 0; i < filter.items.length; i++) {
        array[i] = [filter.items[i].offsetLeft, filter.items[i].offsetTop];
      }
    };
  
    function initItemsOrder(filter) {
      for(var i = 0; i < filter.items.length; i++) {
        filter.items[i].setAttribute('data-init-sort-order', i);
      }
    };
  
    function restoreSortOrder(filter) {
      for(var i = 0; i < filter.items.length; i++) {
        filter.sortingList[parseInt(filter.items[i].getAttribute('data-init-sort-order'))] = [filter.items[i], i];
      }
    };
  
    function resetFallbackMessage(filter, bool) {
      if(!filter.fallbackMessage) return;
      var show = true;
      for(var i = 0; i < filter.filterList.length; i++) {
        if(filter.filterList[i]) {
          show = false;
          break;
        }
      };
      if(bool) { // reset visibility before animation is triggered
        if(!show) Util.addClass(filter.fallbackMessage, 'is-hidden');
        return;
      }
      Util.toggleClass(filter.fallbackMessage, 'is-hidden', !show);
    };
  
    function getMultipleSelectValues(multipleSelect) {
      // get selected options of a <select multiple> element
      var options = multipleSelect.options,
        value = '';
      for(var i = 0; i < options.length; i++) {
        if(options[i].selected) {
          if(value != '') value = value + ':';
          value = value + options[i].value;
        }
      }
      return value;
    };
  
    function resetMarginValues(filter) {
      var gapX = getComputedStyle(filter.element).getPropertyValue('--gap-x'),
        gapY = getComputedStyle(filter.element).getPropertyValue('--gap-y'),
        gap = getComputedStyle(filter.element).getPropertyValue('--gap'),
        gridGap = [0, 0];
      // if the gap property is used to create the grid (not margin left/right) -> get gap values rather than margins
      // check if the --gap/--gap-x/--gap-y
      var newDiv = document.createElement('div'),
        cssText = 'position: absolute; opacity: 0; width: 0px; height: 0px';
      if(gapX && gapY) {
        cssText = 'position: absolute; opacity: 0; width: '+gapX+'; height: '+gapY;
      } else if(gap) {
        cssText = 'position: absolute; opacity: 0; width: '+gap+'; height: '+gap;
      } else if(gapX) {
        cssText = 'position: absolute; opacity: 0; width: '+gapX+'; height: 0px';
      } else if(gapY) {
        cssText = 'position: absolute; opacity: 0; width: 0px; height: '+gapY;
      }
      newDiv.style.cssText = cssText;
      filter.element.appendChild(newDiv);
      var boundingRect = newDiv.getBoundingClientRect();
      gridGap = [boundingRect.width, boundingRect.height];
      filter.element.removeChild(newDiv);
      return gridGap;
    };
  
    Filter.defaults = {
      element : false,
      duration: 400
    };
  
    window.Filter = Filter;
  
    // init Filter object
    var filterGallery = document.getElementsByClassName('js-filter'),
      reducedMotion = Util.osHasReducedMotion();
    if( filterGallery.length > 0 ) {
      for( var i = 0; i < filterGallery.length; i++) {
        var duration = filterGallery[i].getAttribute('data-filter-duration');
        if(!duration) duration = Filter.defaults.duration;
        new Filter({element: filterGallery[i], duration: duration});
      }
    }
  }());
  
// File#: _3_advanced-filter
// Usage: codyhouse.co/license
(function() {
  // the AdvFilter object is used to handle: 
  // - number of results
  // - form reset
  // - filtering sections label (to show a preview of the option selected by the users)
  var AdvFilter = function(element) {
    this.element = element; 
    this.form = this.element.getElementsByClassName('js-adv-filter__form');
    this.resultsList = this.element.getElementsByClassName('js-adv-filter__gallery')[0];
    this.resultsCount = this.element.getElementsByClassName('js-adv-filter__results-count');
    initAdvFilter(this);
  };

  function initAdvFilter(filter) {
    if(filter.form.length > 0) {
      // reset form
      filter.form[0].addEventListener('reset', function(event){
        setTimeout(function(){
          resetFilters(filter);
          resetGallery(filter);
        });
      });
      // update section labels on form change
      filter.form[0].addEventListener('change', function(event){
        var section = event.target.closest('.js-adv-filter__item');
        if(section) resetSelection(filter, section);
        else if( Util.is(event.target, '.js-adv-filter__form') ) {
          // reset the entire form lables
          var sections = filter.form[0].getElementsByClassName('js-adv-filter__item');
          for(var i = 0; i < sections.length; i++) resetSelection(filter, sections[i]);
        }
      });
    }

    // reset results count
    if(filter.resultsCount.length > 0) {
      filter.resultsList.addEventListener('filter-selection-updated', function(event){
        updateResultsCount(filter);
      });
    }
  };

  function resetFilters(filter) {
    // check if there are custom form elemets - reset appearance
    // custom select
    var customSelect = filter.element.getElementsByClassName('js-select');
    if(customSelect.length > 0) {
      for(var i = 0; i < customSelect.length; i++) customSelect[i].dispatchEvent(new CustomEvent('select-updated'));
    }
    // custom slider
    var customSlider = filter.element.getElementsByClassName('js-slider');
    if(customSlider.length > 0) {
      for(var i = 0; i < customSlider.length; i++) customSlider[i].dispatchEvent(new CustomEvent('slider-updated'));
    }
  };

  function resetSelection(filter, section) {
    // change label value based on input types
    var labelSelection = section.getElementsByClassName('js-adv-filter__selection');
    if(labelSelection.length == 0) return;
    // select
    var select = section.getElementsByTagName('select');
    if(select.length > 0) {
      labelSelection[0].textContent = getSelectLabel(section, select[0]);
      return;
    }
    // input number
    var number = section.querySelectorAll('input[type="number"]');
    if(number.length > 0) {
      labelSelection[0].textContent = getNumberLabel(section, number);
      return;
    }
    // input range
    var slider = section.querySelectorAll('input[type="range"]');
    if(slider.length > 0) {
      labelSelection[0].textContent = getSliderLabel(section, slider);
      return;
    }
    // radio/checkboxes
    var radio = section.querySelectorAll('input[type="radio"]'),
      checkbox = section.querySelectorAll('input[type="checkbox"]');
    if(radio.length > 0) {
      labelSelection[0].textContent = getInputListLabel(section, radio);
      return;
    } else if(checkbox.length > 0) {
      labelSelection[0].textContent = getInputListLabel(section, checkbox);
      return;
    }
  };

  function getSelectLabel(section, select) {
    if(select.multiple) {
      var label = '',
        counter = 0;
      for (var i = 0; i < select.options.length; i++) {
        if(select.options[i].selected) {
          label = label + '' + select.options[i].text;
          counter = counter + 1;
        } 
        if(counter > 1) label = section.getAttribute('data-multi-select-text').replace('{n}', counter);
      }
      return label;
    } else {
      return select.options[select.selectedIndex].text;
    }
  };

  function getNumberLabel(section, number) {
    var counter = 0;
    for(var i = 0; i < number.length; i++) {
      if(number[i].value != number[i].min) counter = counter + 1;
    }
    if(number.length > 1) { // multiple input number in this section
      if(counter > 0) {
        return section.getAttribute('data-multi-select-text').replace('{n}', counter);
      } else {
        return section.getAttribute('data-default-text');
      }
      
    } else {
      if(number[0].value == number[0].min) return section.getAttribute('data-default-text');
      else return section.getAttribute('data-number-format').replace('{n}', number[0].value);
    }
  };

  function getSliderLabel(section, slider) {
    var label = '',
      labelFormat = section.getAttribute('data-number-format');
    for(var i = 0; i < slider.length; i++) {
      if(i != 0 ) label = label+' - ';
      label = label + labelFormat.replace('{n}', slider[i].value);
    }
    return label;
  };

  function getInputListLabel(section, inputs) {
    var counter = 0;
      label = '';
    for(var i = 0; i < inputs.length; i++) {
      if(inputs[i].checked) {
        var labelElement = inputs[i].parentNode.getElementsByTagName('label');
        if(labelElement.length > 0) label = labelElement[0].textContent;
        counter = counter + 1;
      }
    }
    if(counter > 1) return section.getAttribute('data-multi-select-text').replace('{n}', counter);
    else if(counter == 0 ) return section.getAttribute('data-default-text');
    else return label;
  };

  function resetGallery(filter) {
    // emit change event + reset filtering 
    filter.form[0].dispatchEvent(new CustomEvent('change'));
    filter.resultsList.dispatchEvent(new CustomEvent('update-filter-results'));
  };

  function updateResultsCount(filter) {
    var resultItems = filter.resultsList.children,
      counter = 0;
    for(var i = 0; i < resultItems.length; i++) {
      if(isVisible(resultItems[i])) counter = counter + 1;
    }
    filter.resultsCount[0].textContent = counter;
  };

  function isVisible(element) {
    return (element.offsetWidth || element.offsetHeight || element.getClientRects().length);
  };
  
  //initialize the AdvFilter objects
  var advFilter = document.getElementsByClassName('js-adv-filter');
  if( advFilter.length > 0 ) {
    for( var i = 0; i < advFilter.length; i++) {
      (function(i){new AdvFilter(advFilter[i]);})(i);
    }
  }

  // Remove the code below if you want to use a custom filtering function (e.g., you need to fetch your results from a database)
  
  // The code below is used for filtering of page content (animation of DOM elements, no fetching results from database).  
  // It uses the Filter component (https://codyhouse.co/ds/components/app/filter) - you can modify the custom filtering functions based on your needs
  // Check the info page of the component for info on how to use it: https://codyhouse.co/ds/components/info/filter
  var gallery = document.getElementById('adv-filter-gallery');
  if(gallery) {
    new Filter({
      element: gallery, // this is your gallery element
      priceRange: function(items){ // this is the price custom function
        var filteredArray = [],
          minVal = document.getElementById('slider-min-value').value,
          maxVal = document.getElementById('slider-max-value').value;
        for(var i = 0; i < items.length; i++) {
          var price = parseInt(items[i].getAttribute('data-price'));
          filteredArray[i] = (price >= minVal) && (price <= maxVal);
        } 
        return filteredArray;
      },
      indexValue: function(items){ // this is the index custom function
        var filteredArray = [],
          value = document.getElementById('index-value').value;
        for(var i = 0; i < items.length; i++) {
          var index = parseInt(items[i].getAttribute('data-sort-index'));
          filteredArray[i] = index >= value;
        } 
        return filteredArray;
      },
      searchInput: function(items) {
        var filteredArray = [],
          value = document.getElementById('search-products').value;
        for(var i = 0; i < items.length; i++) {
          var searchFilter = items[i].getAttribute('data-search');
          filteredArray[i] = searchFilter == '' || searchFilter.toLowerCase().indexOf(value.toLowerCase()) > -1;
        } 
        return filteredArray;
      }
    });
  }
}());