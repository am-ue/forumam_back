
!(function() {
	var forumAM = {};
		forumAM = {
			dom:{
				stickNavLinks : $('.stick_nav li a'),
				presentionBlock : $('.presentation_area'),
				newsItems : $('.news_list > li > a'),
				articleAsidePopin : $('.article_body'),
				articleBackBtn : $('.article_back_btn'),
				mapBlock : $('#map_plan'),
				planSwitchers : $('.plan_switcher_area > button'),
				exposantsItems : $('.exposants_liste li a'),
				exposantsBackbtn : $('.exposant_back_btn'),
				connexionTitle : $(".title_connexion"),
				inscriptionTitle : $(".title_inscription"),

				/* Sections selectors */
				presentationSection : $('#presentation_area'),
				newsSection : $('#news_area'),
				spacesSection : $('#spaces_area'),
				infoPraticSection : $('#info_pratic_area'),
				contactSection : $('#contact_area'),
				forumPlanSection : $('#forum_plan_area'),
				biensepreparerSection : $('#biensepreparer_area'),
				carreSection : $('#carre_area'),
				programmeSection : $('#programme_area')
			},
			vars:{
				isMobile : navigator.userAgent.match(/iPad|iPhone|iPod|Android|Samsung/ig),
				flag : true
			},
			init : function(){
				// calling the functions bellow
				this.menuBtn();
				this.headerBar();
				this.presentionHeight();
				this.scrollToEffect();
				this.articlespopin();
				this.mapPlan();
				this.planSwitcher();
				this.styledDropdown();
				this.connexionSwitcher();

				// To Make specific fixed menu items active according to the main section shoed in the screen
				$(window).scroll(this.scroll);
				$(window).scroll(this.headerBar);
			},
			headerBar: function() {
				if ($(this).scrollTop() >= 50) {
					$('.page_cover').addClass('scrolled');
				}else{
					$('.page_cover').removeClass('scrolled');
				}
			},
			menuBtn: function() {
				$('.menu_btn').on('click', function() {
					if ($(this).hasClass('is-active')) {
						$(this).removeClass('is-active');
					} else {
						$(this).addClass('is-active');
					}
				})
			},
            presentionHeight : function(){
                if (forumAM.dom.presentionBlock.length) {
                	var windowHeight = $(window).outerHeight()
                	var presentationBlockoffset = forumAM.dom.presentionBlock.offset().top;
                	var presentationHeight = windowHeight - presentationBlockoffset;
                	forumAM.dom.presentionBlock.css('height', presentationHeight);
                };
            },
			// To animate the default scrolling to any of he main sections
			scrollToEffect : function(){
				forumAM.dom.stickNavLinks.on('click',function(e){
					e.preventDefault();
					var _this = $(this);
					var targetLinkOffset = $(_this.attr('href')).offset().top - 62
					// $('.stick_nav li a').removeClass('active');
					_this.addClass('active');

					/*$('html,body');*/
					$('html,body').stop().animate({ scrollTop: targetLinkOffset },1200);
				});
				$('.scroll_btm').on('click',function(e){
					e.preventDefault();
					var _this = $(this);
					var targetLinkOffset = $(_this.attr('href')).offset().top - 62
					// $('.stick_nav li a').removeClass('active');
					_this.addClass('active');

					/*$('html,body');*/
					$('html,body').stop().animate({ scrollTop: targetLinkOffset },1200);
				});
			},
			// To Make specific fixed menu items active according to the main section shoed in the screen
			scroll : function(){
				if ($('.home_page').length) {
					if( $(this).scrollTop() >= forumAM.dom.presentationSection.offset().top - 300 ){

						forumAM.dom.stickNavLinks.removeClass("active");
						$('.stick_nav li a[href=#' + forumAM.dom.presentationSection.attr('id') + ']').addClass("active");
					}
					if( $(this).scrollTop() >= forumAM.dom.newsSection.offset().top - 300 ){

						forumAM.dom.stickNavLinks.removeClass("active");
						$('.stick_nav li a[href=#' + forumAM.dom.newsSection.attr('id') + ']').addClass("active");
					}
					if( $(this).scrollTop() >= forumAM.dom.spacesSection.offset().top - 300 ){

						forumAM.dom.stickNavLinks.removeClass("active");
						$('.stick_nav li a[href=#' + forumAM.dom.spacesSection.attr('id') + ']').addClass("active");
					}
					if( $(this).scrollTop() >= forumAM.dom.infoPraticSection.offset().top - 300 ){

						forumAM.dom.stickNavLinks.removeClass("active");
						$('.stick_nav li a[href=#' + forumAM.dom.infoPraticSection.attr('id') + ']').addClass("active");
					}
					if( $(this).scrollTop() >= forumAM.dom.contactSection.offset().top - 300 ){

						forumAM.dom.stickNavLinks.removeClass("active");
						$('.stick_nav li a[href=#' + forumAM.dom.contactSection.attr('id') + ']').addClass("active");
					}
					
				};
				if ($('.info_pratic_page').length) {
					if( $(this).scrollTop() >= forumAM.dom.forumPlanSection.offset().top - 300 ){

						forumAM.dom.stickNavLinks.removeClass("active");
						$('.stick_nav li a[href=#' + forumAM.dom.forumPlanSection.attr('id') + ']').addClass("active");
					}
					if( $(this).scrollTop() >= forumAM.dom.infoPraticSection.offset().top - 300 ){

						forumAM.dom.stickNavLinks.removeClass("active");
						$('.stick_nav li a[href=#' + forumAM.dom.infoPraticSection.attr('id') + ']').addClass("active");
					}

				};
				if ($('.biensepreparer_page').length) {
					if( $(this).scrollTop() >= forumAM.dom.biensepreparerSection.offset().top - 300 ){

						forumAM.dom.stickNavLinks.removeClass("active");
						$('.stick_nav li a[href=#' + forumAM.dom.biensepreparerSection.attr('id') + ']').addClass("active");
					}
					if( $(this).scrollTop() >= forumAM.dom.carreSection.offset().top - 300 ){

						forumAM.dom.stickNavLinks.removeClass("active");
						$('.stick_nav li a[href=#' + forumAM.dom.carreSection.attr('id') + ']').addClass("active");
					}
					if( $(this).scrollTop() >= forumAM.dom.programmeSection.offset().top - 300 ){

						forumAM.dom.stickNavLinks.removeClass("active");
						$('.stick_nav li a[href=#' + forumAM.dom.programmeSection.attr('id') + ']').addClass("active");
					}
				};
			},
            articlespopin : function(){
                if (forumAM.dom.newsItems.length) {
                	forumAM.dom.newsItems.on('click', function(){
                		forumAM.dom.articleAsidePopin.addClass('active');
                		var targetLinkOffset = forumAM.dom.newsSection.offset().top - 62
						$('html,body').stop().animate({ scrollTop: targetLinkOffset },600);
                		return false;
                	})
                	forumAM.dom.articleBackBtn.on('click', function(){
                		forumAM.dom.articleAsidePopin.removeClass('active');
                		return false;
                	})
                };
                if (forumAM.dom.exposantsItems.length) {
                	var BodyScrollTop;
                	forumAM.dom.exposantsItems.on('click', function(){
                		BodyScrollTop = $('body').scrollTop();
                		if ($('body').hasClass('exposant_opened')) {
                			$('body').removeClass('exposant_opened')
                		}else{
                			$('body').addClass('exposant_opened')
                		}
                		forumAM.dom.exposantsItems.removeClass('active')
                		$(this).addClass('active');

						$('html,body').stop().animate({ scrollTop: 0 },300);
                		return false;
                	})
                	forumAM.dom.exposantsBackbtn.on('click', function(){
            			$('body').removeClass('exposant_opened')
						$('html,body').stop().animate({ scrollTop: BodyScrollTop },300);
                	})
                };
            },
            mapPlan : function(){
                if (forumAM.dom.mapBlock.length) {

				var myLatlng = new google.maps.LatLng(48.844559, 2.434568);

				var styleArray = 
				[
				    {
				        "featureType": "administrative.land_parcel",
				        "elementType": "all",
				        "stylers": [
				            {
				                "visibility": "off"
				            }
				        ]
				    },
				    {
				        "featureType": "poi",
				        "elementType": "all",
				        "stylers": [
				            {
				                "visibility": "off"
				            }
				        ]
				    },
				    {
				        "featureType": "poi.park",
				        "elementType": "all",
				        "stylers": [
				            {
				                "visibility": "off"
				            }
				        ]
				    },
				    {
				        "featureType": "poi.sports_complex",
				        "elementType": "all",
				        "stylers": [
				            {
				                "visibility": "off"
				            }
				        ]
				    },
				    {
				        "featureType": "road.highway",
				        "elementType": "geometry.fill",
				        "stylers": [
				            {
				                "color": "#8e2862"
				            },
				            {
				                "saturation": "76"
				            },
				            {
				                "visibility": "on"
				            },
				            {
				                "weight": "0.62"
				            }
				        ]
				    },
				    {
				        "featureType": "road.highway",
				        "elementType": "geometry.stroke",
				        "stylers": [
				            {
				                "visibility": "off"
				            },
				            {
				                "saturation": "0"
				            }
				        ]
				    },
				    {
				        "featureType": "road.arterial",
				        "elementType": "geometry.fill",
				        "stylers": [
				            {
				                "color": "#f39200"
				            },
				            {
				                "weight": "0.43"
				            }
				        ]
				    },
				    {
				        "featureType": "road.local",
				        "elementType": "geometry.fill",
				        "stylers": [
				            {
				                "color": "#f5f5f5"
				            },
				            {
				                "visibility": "on"
				            }
				        ]
				    },
				    {
				        "featureType": "water",
				        "elementType": "geometry.fill",
				        "stylers": [
				            {
				                "color": "#d3d3d3"
				            }
				        ]
				    }
				]
				var mapOptions = {
				  zoom: 14,
				  center: myLatlng,
				  mapTypeId: google.maps.MapTypeId.ROADMAP,
				  disableDefaultUI: true,
				  styles: styleArray,
				  scrollwheel: false,
				  draggable: false
				};
				var map = new google.maps.Map(document.getElementById("map_plan"), mapOptions);
				

				//add a custom marker to the map			
				marker = new google.maps.Marker({
                    position: new google.maps.LatLng(48.836291, 2.434390),
                    map: map,
                    visible:true,
                    icon: 'img/default_marker.png',
                });
                };
            },
            planSwitcher : function(){
            	forumAM.dom.planSwitchers.on('click', function(){
            		forumAM.dom.planSwitchers.removeClass('active');
            		$(this).addClass('active');

            		$('.plan_switcher_content > div').hide()
            		$($(this).attr('data-target')).show()
            	})
            },
            styledDropdown : function(){
            	$(".styled_dropdown").chosen({disable_search_threshold: 10});

            },
			connexionSwitcher : function(){
				/* afficher block connexion */
				forumAM.dom.connexionTitle.on('click', function () {
					forumAM.dom.inscriptionTitle.removeClass("active");
					$(this).addClass("active");
					$("#espace_inscription").hide();
					$("#espace_connexion").show();
					return false;
				});
				/* afficher block inscription */
				forumAM.dom.inscriptionTitle.on('click', function () {
					forumAM.dom.connexionTitle.removeClass("active");
					$(this).addClass("active");
					$("#espace_inscription").show();
					$("#espace_connexion").hide();
					return false;
				});
			}

        }
		//call init function on document ready
		$(function() {
			forumAM.init();

		});
})(window.jQuery);
