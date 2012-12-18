(function($) {

	var objImagePreloader;
	/**
	 * $ is an alias to jQuery object
	 *
	 */
	$.fn.lightBox = function(settings) {
		// Settings to configure the jQuery lightBox plugin how you like
		settings = jQuery.extend({
			// Configuration related to overlay
			overlayBgColor: 		'#000',		// (string) Background color to overlay; inform a hexadecimal value like: #RRGGBB. Where RR, GG, and BB are the hexadecimal values for the red, green, and blue values of the color.
			overlayOpacity:			0.2,		// (integer) Opacity value to overlay; inform: 0.X. Where X are number from 0 to 9
			// Configuration related to navigation
			fixedNavigation:		false,		// (boolean) Boolean that informs if the navigation (next and prev button) will be fixed or not in the interface.
			// Configuration related to container image box
			containerBorderSize:	10,			// (integer) If you adjust the padding in the CSS for the container, #lightbox-container-image-box, you will need to update this value
			containerResizeSpeed:	400,		// (integer) Specify the resize duration of container image. These number are miliseconds. 400 is default.
			// Configuration related to texts in caption. For example: Image 2 of 8. You can alter either "Image" and "of" texts.
			txtImage:				'Image',	// (string) Specify text "Image"
			txtOf:					'of',		// (string) Specify text "of"
			// Configuration related to keyboard navigation
			keyToClose:				'c',		// (string) (c = close) Letter to close the jQuery lightBox interface. Beyond this letter, the letter X and the SCAPE key is used to.
			keyToPrev:				'p',		// (string) (p = previous) Letter to show the previous image
			keyToNext:				'n',		// (string) (n = next) Letter to show the next image.
			// Don�t alter these variables in any way
			imageArray:				[],
			activeImage:			0
		},settings);
		// Caching the jQuery object with all elements matched
		var jQueryMatchedObj = this; // This, in this context, refer to jQuery object
		/**
		 * Initializing the plugin calling the start function
		 *
		 * @return boolean false
		 */
		function _initialize() {
			_start(this,jQueryMatchedObj); // This, in this context, refer to object (link) which the user have clicked
			
			return false; // Avoid the browser following the link
		}
		
		/**
		* @author: Hersilio belini de Oliveira
		* @param: objLink link para verifica��o
		* @return: boolean 
		* @descrition:Verifica se o link � para uma imagem
		**/
		function _verificarExtensao(objLink){
			//var extensoes = {'jpg','jpeg','png','gif'};
			var extensaoLink = objLink.getAttribute('href').toLowerCase();
			var ext = extensaoLink.substring((extensaoLink.length)-4,(extensaoLink.length));
			
			if(ext == 'jpeg' || 
			   ext == '.jpg' || 			   
			   ext == '.png' || 
			   ext == '.gif' || 
			   ext == '.bmp' ||
			   ext == '.tif')
				return true;
			else
				return false;				
			
		}
		
		
		/**
		 * Start the jQuery lightBox plugin
		 *
		 * @param object objClicked The object (link) whick the user have clicked
		 * @param object jQueryMatchedObj The jQuery object with all elements matched
		 */
		function _start(objClicked,jQueryMatchedObj) {
			
			if(_verificarExtensao(objClicked)){
				
				objImagePreloader = new Image();
				
				objImagePreloader.src = objClicked.getAttribute('href');
			
				var imagemWidth = (objImagePreloader.width + (settings.containerBorderSize * 2));
				var imagemHeight = (objImagePreloader.height + (settings.containerBorderSize * 2));
				
				_openPopUp(objImagePreloader.src,imagemWidth,imagemHeight);
				
			}
			else
			{
				var target = objClicked.getAttribute('target');
				
				if(target == '_top')
				{
					top.location.href = objClicked.getAttribute('href');
				}
				else if(target == '_parent')
				{
					parent.location.href = objClicked.getAttribute('href');
				}
				else
					window.open(objClicked.getAttribute('href'));
			}
		}

			
		function _openPopUp(url,imagemWidth,imagemHeight) {
	
			var left = (screen.width) ? (screen.width-imagemWidth)/2 : 0;
			var top = (screen.height) ? (screen.height-imagemHeight)/2 : 0;
			
			window.open(url,'','paramters='+url+',status=1,resizable=1,toolbar=1,location=0,menubar=0,scrollbars=0,Width='+imagemWidth+',Height='+imagemHeight+',left='+left+',top='+top+'');
		}
		
		return this.unbind('click').click(_initialize);
	};
})(jQuery); // Call and execute the function immediately passing the jQuery object