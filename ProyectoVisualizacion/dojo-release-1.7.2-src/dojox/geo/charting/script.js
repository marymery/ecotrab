<script type="text/javascript">
			dojo.require("dojox.geo.charting.Map");
			dojo.require("dojox.charting.Chart");
			dojo.require("dojox.charting.axis2d.Default");
      		dojo.require("dojox.charting.plot2d.ClusteredBars");
			dojo.require("dojox.charting.plot2d.Grid");
			dojo.require("dojo.data.ItemFileReadStore");
			dojo.requireIf(isTouchDevice,"dojox.geo.charting.TouchInteractionSupport");
			dojo.requireIf(!isTouchDevice,"dojox.geo.charting.MouseInteractionSupport");
			dojo.require("dojox.geo.charting.KeyboardInteractionSupport");
			dojo.require("dojox.charting.themes.PlotKit.blue");

////////////////////////////////////////////////////////////////////////
			dojo.require("dojox.layout.FloatingPane");

var pFloatingPanes = new Array();			
//var pFloatingPane;
			
			var texto;
			var texto2;

		// EJEMPLO DE CONSULTA
		var chartStore = new dojo.data.ItemFileReadStore({
				url: "datastore/dataStore.json"
			});
			
			
			chartStore.fetchItemByIdentity({
                                        identity: "VT",
                                        onItem: function(item){

                                         texto2 = chartStore.getValue( item, "product B" );
                                       }
                        });



			// Inicializo LUGO
                        dojo.ready(function(){
                          pFloatingPanes[0] = new dojox.layout.FloatingPane({

                             title: texto2,
                             resizable: true, dockable: true,
                             style: "position:absolute;top:0;left:0;width:100px;height:100px;visibility:hidden;",
                             id: "pFloatingPaneLUGO"
                          }, dojo.byId("pFloatingPaneLUGO"));

                          pFloatingPanes[0].startup();
                        });
			
			// Inicializo panel en caso de OURENSE
			dojo.ready(function(){
                          pFloatingPanes[1] = new dojox.layout.FloatingPane({
				content: "contenido",
                             title: "A floating pane",
                             resizable: true, dockable: true,
                             style: "position:absolute;top:0;left:0;width:100px;height:100px;visibility:hidden;",
                             id: "pFloatingPaneOURENSE"
                          }, dojo.byId("pFloatingPaneOURENSE"));

                          pFloatingPanes[1].startup();
                        });


			
                        //document.write(texto);
                        //document.write(texto2);
                     		

			var chart,series,productList;
			var texto4 = "texto4";



			dojo.addOnLoad(function(){
				//document.write(texto);
				//document.write(texto2);

				productSeries = [0,0,0,0,0,0];
            	productList = ["product A", "product B","product C","product D","product E","product F"];
			
				
				var map = new dojox.geo.charting.Map("map", "../resources/data/USStates.json");
				map.setMarkerData("../resources/markers/USStates.json");
				// install mouse/touch navigation
				if (!isTouchDevice) {
					var mouseInteraction = new dojox.geo.charting.MouseInteractionSupport(map,{enablePan:true,enableZoom:true});
					mouseInteraction.connect();
				
				} else {
					var touchInteraction = new dojox.geo.charting.TouchInteractionSupport(map,{});
					touchInteraction.connect();
					// Aqui no entra

				}

				var keyboardInteraction = new dojox.geo.charting.KeyboardInteractionSupport(map, {enableZoom: true});
				keyboardInteraction.connect();

				map.onFeatureClick = function(feature){
				
					//document.write("Raton encima");

					//////////////////////////////
					var r = "";
					texto4 = feature["id"].toString();
					if(texto4 == "LUGO"){
						//document.write("ESLUGO");
						texto2="contenido del panel de lugo";
						pFloatingPanes[0].show();

					}


					else if(texto4 == "OURENSE"){

						pFloatingPanes[1].show();
					}
					// Si no tenemos el cursor encima de alguna provincia, no mostramos ningun panel
					else{
					
						var contador = 0;
						for(var i in pFloatingPanes){
							pFloatingPanes[contador].hide();
							contador++;
						}
						
					}
/////////////////////////////		
							
					if (!feature) {
						productSeries = [0,0,0,0,0,0];
						chart.updateSeries("productSeries",productSeries);
						chart.render();


					} else if (!feature.isSelected) {
content: "contenido",

						chartStore.fetchItemByIdentity({
			            	identity: feature.id,
			            	onItem: function(item){
				                for (var i = productList.length - 1; i >= 0; i--){
																	


								//document.write("entra else");


									productSeries[i] = chartStore.getValue(item, productList[i]);
								//document.write("pepito");
								//document.write(productSeries[i]);
								};
								chart.updateSeries("productSeries",productSeries);
								chart.render();
			            	}
			        	});
					}
				};
			});
		</script>
