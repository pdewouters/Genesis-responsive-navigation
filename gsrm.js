var create_name = function(text) {
  // Convert text to lower case.
  var name = text.toLowerCase();
  
  // Remove leading and trailing spaces, and any non-alphanumeric
  // characters except for ampersands, spaces and dashes.
  name = name.replace(/^\s+|\s+jQuery|[^a-z0-9&\s-]/g, '');
  
  // Replace '&' with 'and'.
  name = name.replace(/&/g, 'and');
  
  // Replaces spaces with dashes.
  name = name.replace(/\s/g, '-');
  
  // Squash any duplicate dashes.
  name = name.replace(/(-)+\1/g, "jQuery1");
  
  return name;
};

var add_link = function() {
  // Convert the h2 element text into a value that
  // is safe to use in a name attribute.
  var name = create_name(jQuery(this).text());
  
  // Create a name attribute in the following div.toggle
  // to act as a fragment anchor.
  jQuery(this).next('div.toggle').attr('name', name);
  
  // Replace the h2.toggle element with a link to the
  // fragment anchor.  Use the h2 text to create the
  // link title attribute.
  jQuery(this).html(
    '<a href="#' + name + '" title="Reveal ' +
    jQuery(this).text() + ' content">' +
    jQuery(this).html() + '</a>');
};

var toggle = function(event) {
  event.preventDefault();

  // Toggle the 'expanded' class of the h2.toggle
  // element, then apply the slideToggle effect
  // to div.toggle siblings.
  jQuery(this).
    toggleClass('expanded').
    nextAll('div.toggle').slideToggle('fast');
};

var remove_focus = function() {
  // Use the blur() method to remove focus.
  jQuery(this).blur();
};

jQuery(document).ready (function ($){
  // Replace the '_toggle' class with 'toggle'. 
  $('._toggle').
    removeClass('_toggle').
    addClass('toggle');
    
  // Replace the '_expanded' class with 'expanded'. 
  $('._expanded').
    removeClass('_expanded').
    addClass('expanded');
  
  // Hide all div.toggle elements that are not initially expanded.
  $('h2.toggle:not(.expanded)').nextAll('div.toggle').hide();
  
  // Add a link to each h2.toggle element.
  $('h2.toggle').each(add_link);
  
  // Add a click event handler to all h2.toggle elements.
  $('h2.toggle').click(toggle);
  
  // Remove the focus from the link tag when accessed with a mouse.
  $('h2.toggle a').mouseup(remove_focus);
});