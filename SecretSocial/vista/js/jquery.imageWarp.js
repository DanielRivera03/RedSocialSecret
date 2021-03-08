/* imageWarp jQuery plugin v1.01
* Last updated: June 29th, 2009. This notice must stay intact for usage 
* Author: Dynamic Drive at http://www.dynamicdrive.com/
* Visit http://www.dynamicdrive.com/ for full source code
*/

jQuery.noConflict()

jQuery.imageWarp={
	dsettings: {
		warpfactor: 1.5, //default increase factor of enlarged image
		duration: 1000, //default duration of animation, in millisec
		imgopacity: [0.5, 1],
		warpopacity: [0.1, 0.5]
 	},
	warpshells: [],

	refreshoffsets:function($target, warpshell){
		var $offsets=$target.offset()
		warpshell.attrs.x=$offsets.left //update x position of original image relative to page
		warpshell.attrs.y=$offsets.top
		warpshell.newattrs.x=warpshell.attrs.x-((warpshell.newattrs.w-warpshell.attrs.w)/2) //update x position of final warped image relative to page
		warpshell.newattrs.y=warpshell.attrs.y-((warpshell.newattrs.h-warpshell.attrs.h)/2)
	},

	addEffect:function($, $target, options){
		var setting={} //create blank object to store combined settings
		var setting=jQuery.extend(setting, this.dsettings, options)
		var effectpos=this.warpshells.length
		var attrs={w:$target.outerWidth(), h:$target.outerHeight()}
		var newattrs={w:Math.round(attrs.w*setting.warpfactor), h:Math.round(attrs.h*setting.warpfactor)}
		var $clone=$target.clone().css({position:'absolute', left:0, top:0, visibility:'hidden', border:'1px solid gray', zIndex:1000}).appendTo(document.body)
		$target.add($clone).data('pos', effectpos) //save position of image
		var $targetlink=$target.parents('a').eq(0)
		this.warpshells.push({$clone:$clone, attrs:attrs, newattrs:newattrs, $link:($targetlink.length==1)? $targetlink : null}) //remember info about this warp image instance
		$target.click(function(e){
			var $this=$(this).css({opacity:setting.imgopacity[0]})
			var imageinfo=jQuery.imageWarp.warpshells[$(this).data('pos')]
			jQuery.imageWarp.refreshoffsets($this, imageinfo) //refresh offset positions of original and warped images
			if (imageinfo.$link){
				e.preventDefault()
			}
			var $clone=imageinfo.$clone
			$clone.stop().css({left:imageinfo.attrs.x, top:imageinfo.attrs.y, width:imageinfo.attrs.w, height:imageinfo.attrs.h, opacity:setting.warpopacity[0], visibility:'visible'})
			.animate({opacity:setting.warpopacity[1], left:imageinfo.newattrs.x, top:imageinfo.newattrs.y, width:imageinfo.newattrs.w, height:imageinfo.newattrs.h}, setting.duration,
			function(){ //callback function after warping is complete
				$clone.css({left:0, top:0, visibility:'hidden'})
				$this.css({opacity:setting.imgopacity[1]})
			if (imageinfo.$link){
				window.location=imageinfo.$link.attr('href')
			}			
			}) //end animate
		}) //end click
	}
};

jQuery.fn.imageWarp=function(options){
	var $=jQuery
	return this.each(function(){ //return jQuery obj
		var $imgref=$(this)
		if (this.tagName!="IMG")
			return true //skip to next matched element
		if (parseInt($imgref.css('width'))>0 && parseInt($imgref.css('height'))>0){ //if image has explicit width/height attrs defined
			jQuery.imageWarp.addEffect($, $imgref, options)
		}
		else if (this.complete){ //account for IE not firing image.onload
			jQuery.imageWarp.addEffect($, $imgref, options)
		}
		else{
			$(this).bind('load', function(){
				jQuery.imageWarp.addEffect($, $imgref, options)
			})
		}
	})
};