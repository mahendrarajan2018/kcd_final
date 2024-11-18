var city_district_arr = new Array("Ariyalur", "Chengalpattu", "Chennai", "Coimbatore", "Cuddalore", "Dharmapuri", "Dindigul", "Erode", "Kallakurichi", "Kanchipuram", "Kanniyakumari", "Karur", "Krishnagiri", "Madurai", "Mayiladuthurai", "Nagapattinam", "Namakkal", "Perambalur", "Pudukkottai", "Ramanathapuram", "Ranipet", "Salem", "Sivaganga", "Tenkasi", "Thanjavur", "Theni", "The Nilgiris", "Thiruvallur", "Thiruvarur", "Tiruchirappalli", "Tirunelveli", "Tirupathur", "Tiruppur", "Tiruvannamalai", "Tuticorin", "Vellore", "Villupuram", "Virudhunagar");

var city_index = new Array();
city_index[1]="Others|Andimadam|Ariyalur|Sendurai|Udayarpalayam";
city_index[2]="Others|Chengalpattu|Cheyyur|Maduranthakam|Pallavaram|Tambaram|Tirukalukundram|Tiruporur|Vandalur";
city_index[3]="Others|Alandur|Ambattur|Aminjikarai|Ayanavaram|Egmore|Guindy|Maduravoyal|Mambalam|Mathavaram|Mylapore|Perambur|Purasawalkam|Sholinganallur|Tiruvottiyur|Tondiarpet|Velachery";
city_index[4]="Others|Anaimalai|Annur|Coimbatore North|Coimbatore South|Kinathukadavu|Madukkari|Mettupalayam|Perur|Pollachi|Sulur|Valparai";
city_index[5]="Others|Bhuvanagiri|Chidambaram|Cuddalore|Kattumannarkoil|Kurinjipadi|Panruti|Srimushnam|Tittakudi|Veppur|Virudhachalam";
city_index[6]="Others|Dharmapuri|Harur|Karimangalam|Nallampalli|Palakkodu|Pappireddipatti|Pennagaram";
city_index[7]="Others|Athoor|Dindiguleast|Dindigulwest|Gujiliamparai|Kodaikanal|Natham|Nilakkottai|Oddanchatram|Palani|Vedasandur";
city_index[8]="Others|Anthiyur|Bhavani|Erode|Gobichettipalayam|Kodumudi|Modakkurichi|Nambiyur|Perundurai|Sathyamangalam|Thalavadi";
city_index[9]="Others|Chinnasalem|Kallakkurichi|Kalvarayan Hills|Sankarapuram|Tirukkoyilur|Ulundurpettai";
city_index[10]="Others|Kancheepuram|Kundrathur|Sriperumbudur|Uthiramerur|Walajabad";
city_index[11]="Others|Agastheeswaram|Kalkulam|Killiyoor|Thiruvattar|Thovala|Vilavancode";
city_index[12]="Others|Aravakurichi|Kadavur|Karur|Krishnarayapuram|Kulithalai|Manmangalam|Pugalur";
city_index[13]="Others|Anchetty|Bargur|Denkanikottai|Hosur|Krishnagiri|Pochampalli|Shoolagiri|Uthangarai";
city_index[14]="Others|Kalligudi|Madurai East|Madurai North|Madurai South|Madurai West|Melur|Peraiyur|Thirumangalam|Thirupparankundram|Usilampatti|Vadipatti";
city_index[15]="Others|Kuthalam|Mayiladuthurai|Sirkali|Tharangambadi";
city_index[16]="Others|Kilvelur|Nagapattinam|Thirukkuvalai|Vedaranyam";
city_index[17]="Others|Kolli Hills|Kumarapalayam|Mohanur|Namakkal|Paramathi-Velur|Rasipuram|Sendamangalam|Tiruchengode";
city_index[18]="Others|Alathur|Kunnam|Perambalur|Veppanthattai";
city_index[19]="Others|Alangudi|Aranthangi|Avudayarkoil|Gandarvakkottai|Iluppur|Karambakudi|Kulathur|Manamelkudi|Ponnamaravathi|Pudukkottai|Thirumayam|Viralimalai";
city_index[20]="Others|Kadaladi|Kamuthi|Kilakarai|Mudukulathur|Paramakudi|Rajasingamangalam|Ramanathapuram|Rameswaram|Tiruvadanai";
city_index[21]="Others|Arakonam|Arcot|Kalavai|Nemili|Sholinghur|Wallajah";
city_index[22]="Others|Attur|Edappadi|Gangavalli|Kadayampatti|Mettur|Omalur|Pethanaickanpalayam|Salem|Salem South|Salem West|Sankari|Thalaivasal|Vazhapadi|Yercaud";
city_index[23]="Others|Devakottai|Ilayangudi|Kalaiyarkoil|Karaikkudi|Manamadurai|Singampunari|Sivaganga|Thiruppathur|Thiruppuvanam";
city_index[24]="Others|Alangulam|Kadayanallur|Sankarankoil|Shenkottai|Sivagiri|Tenkasi|Tiruvengadam|Veerakeralamputhur";
city_index[25]="Others|Budalur|Kumbakonam|Orathanadu|Papanasam|Pattukkottai|Peravurani|Thanjavur|Thiruvaiyaru|Thiruvidaimarudur";
city_index[26]="Others|Andipatti|Bodinayakanur|Periyakulam|Theni|Uthamapalayam";
city_index[27]="Others|Coonoor|Gudalur|Kotagiri|Kundah|Panthalur|Udhagamandalam";
city_index[28]="Others|Avadi|Gummidipoondi|Pallipattu|Ponneri|Poonamallee|R K Pet|Thiruvallur|Tiruttani|Uthukkottai";
city_index[29]="Others|Koothanallur|Kudavasal|Mannargudi|Nannilam|Needamangalam|Thiruthuraipoondi|Thiruvarur|Valangaiman";
city_index[30]="Others|Lalgudi|Manachanallur|Manapparai|Marungapuri|Musiri|Srirangam|Thiruverumbur|Thottiyam|Thuraiyur|Tiruchirappalli East|Tiruchirappalli West";
city_index[31]="Others|Ambasamudram|Cheranmahadevi|Manur|Nanguneri|Palayamkottai|Radhapuram|Tirunelveli|Tisayanvilai";
city_index[32]="Others|Ambur|Natrampalli|Tirupathur|Vaniyambadi";
city_index[33]="Others|Avanashi|Dharapuram|Kangeyam|Madathukulam|Palladam|Tiruppurnorth|Tiruppursouth|Udumalaipettai|Uthukuli";
city_index[34]="Others|Arani|Chengam|Chetpet|Cheyyar|Jamunamarathoor|Kalasapakkam|Kilpennathur|Polur|Thandrampet|Tiruvannamalai|Vandavasi|Vembakkam";
city_index[35]="Others|Eral|Ettayapuram|Kayathar|Kovilpatti|Ottapidaram|Sathankulam|Srivaikuntam|Thoothukkudi|Tiruchendur|Vilathikulam";
city_index[36]="Others|Anaicut|Gudiyatham|Katpadi|K V Kuppam|Pernambut|Vellore";
city_index[37]="Others|Gingee|Kandachipuram|Marakanam|Melmalaiyanur|Thiruvennainallur|Tindivanam|Vanur|Vikravandi|Viluppuram";
city_index[38]="Others|Aruppukkottai|Kariapatti|Rajapalayam|Sattur|Sivakasi|Srivilliputhur|Tiruchuli|Vembakottai|Virudhunagar|Watrap";


function getCities(form_name, district, city) {
	if (jQuery('form[name="'+form_name+'_form"]').find('select[name="city"]').length > 0) {
		
		var selectedDistrictIndex = document.forms[form_name+"_form"]["district"].selectedIndex;
		var district = city_district_arr[selectedDistrictIndex - 1];
		var selected_district = document.forms[form_name+"_form"]["district"].value;
		var selected_state = document.forms[form_name+"_form"]["state"].value;
		if(selected_state != "Tamil Nadu"){
			district = selected_district;
		}
		var cityElement = document.forms[form_name+"_form"]["city"];
		cityElement.length = 0;
		cityElement.options[0] = new Option('Select', '');
		cityElement.selectedIndex = 0;
		if (district == selected_district) {
			if(city == 'Others'){
				if(jQuery('#others_city_cover').hasClass('d-none') !== false)
				{
					jQuery('#others_city_cover').removeClass('d-none');
				}
				var post_url = "dashboard_changes.php?check_login_session=1";
				jQuery.ajax({
					url: post_url, success: function (check_login_session) {
						if (check_login_session == 1) {
							var post_url = "common_changes.php?others_city=1&selected_district="+selectedDistrictIndex+"&form_name="+form_name;
							jQuery.ajax({
								url: post_url, success: function (result) {
									if(jQuery('#others_city_cover').length >0)
									{
										jQuery('#others_city_cover').html(result);
									}
								}
							});
						}
						else {
							window.location.reload();
						}
					}
				});
			}
			else
			{
				if(jQuery('#others_city_cover').hasClass('d-none') == false)
				{
					jQuery('#others_city_cover').addClass('d-none');
				}
				jQuery('input[name="others_city"]').val('');
			}
			if(selected_state == "Tamil Nadu"){
				if(typeof city_index[selectedDistrictIndex] != 'undefined' && city_index[selectedDistrictIndex] != null)
				{
					var city_arr = city_index[selectedDistrictIndex].split("|");
					var others_city = new Array();
					var post_url ="common_changes.php?get_city=1&get_district="+district;
					jQuery.ajax({
						url:post_url,success:function(result){
							result = result.replace('\r\n', '');
							if(result != '' && result != 'NULL')
							{
								others_city =result.split(',');
								for(var i = 0;i < others_city.length;i++)
								{
									others_city[i] = others_city[i].replace('\r\n', '');
									if(!city_arr.includes(others_city[i])) {
										city_arr.push(others_city[i]);
									}
									
								}
							}
							for (var i = 0; i < city_arr.length; i++) {
								cityElement.options[cityElement.length] = new Option(city_arr[i], city_arr[i]);
								if (city_arr[i] == city) {
									cityElement.selectedIndex = parseInt(i) + 1;
								}
							}
						}
					});
				}	
			}
			else{
				var city_arr = new Array("Others");
				var others_city = new Array();
				var post_url ="common_changes.php?get_city=1&get_district="+district;
				jQuery.ajax({
					url:post_url,success:function(result){
						result =result.replace('\r\n', '');
						if(result != '' && result != 'NULL')
						{
							others_city =result.split(',');
							for(var i = 0;i < others_city.length;i++)
							{
								others_city[i] =others_city[i].replace('\r\n', '');
								if(!city_arr.includes(others_city[i])) {
									city_arr.push(others_city[i]);
								}
							}
						}

						for (var i = 0; i < city_arr.length; i++) {
							cityElement.options[cityElement.length] = new Option(city_arr[i], city_arr[i]);
							if (city_arr[i] == city) {
								cityElement.selectedIndex = parseInt(i) + 1;
							}
						}	
					}
				});
			}
		}
	}
}

function getLRPartyCities(form_name, party_name, district, city) {
	if (jQuery('form[name="'+form_name+'_form"]').find('select[name="'+party_name+'_city"]').length > 0) {
		
		var selectedDistrictIndex = document.forms[form_name+"_form"][party_name+"_district"].selectedIndex;
		var district = city_district_arr[selectedDistrictIndex - 1];
		var selected_district = document.forms[form_name+"_form"][party_name+"_district"].value;
		var selected_state = document.forms[form_name+"_form"][party_name+"_state"].value;
		if(selected_state != "Tamil Nadu"){
			district = selected_district;
		}
		var cityElement = document.forms[form_name+"_form"][party_name+"_city"];
		cityElement.length = 0;
		cityElement.options[0] = new Option('Select', '');
		cityElement.selectedIndex = 0;
		if (district == selected_district) {
			if(city == 'Others'){
				if(jQuery('#'+party_name+'_others_city_cover').hasClass('d-none') !== false)
				{
					jQuery('#'+party_name+'_others_city_cover').removeClass('d-none');
				}
				/*var post_url = "dashboard_changes.php?check_login_session=1";
				jQuery.ajax({
					url: post_url, success: function (check_login_session) {
						if (check_login_session == 1) {
							var post_url = "common_changes.php?others_city=1&selected_district="+selectedDistrictIndex+"&form_name="+form_name;
							jQuery.ajax({
								url: post_url, success: function (result) {
									if(jQuery('#'+party_name+'_others_city_cover').length >0)
									{
										jQuery('#'+party_name+'_others_city_cover').html(result);
									}
								}
							});
						}
						else {
							window.location.reload();
						}
					}
				});*/
			}
			else
			{
				if(jQuery('#'+party_name+'_others_city_cover').hasClass('d-none') == false)
				{
					jQuery('#'+party_name+'_others_city_cover').addClass('d-none');
				}
				jQuery('input[name="'+party_name+'_others_city"]').val('');
			}
			if(selected_state == "Tamil Nadu"){
				if(typeof city_index[selectedDistrictIndex] != 'undefined' && city_index[selectedDistrictIndex] != null)
				{
					var city_arr = city_index[selectedDistrictIndex].split("|");
					var others_city = new Array();
					var post_url ="common_changes.php?get_city=1&get_district="+district;
					jQuery.ajax({
						url:post_url,success:function(result){
							result = result.replace('\r\n', '');
							if(result != '' && result != 'NULL')
							{
								others_city =result.split(',');
								for(var i = 0;i < others_city.length;i++)
								{
									others_city[i] = others_city[i].replace('\r\n', '');
									if(!city_arr.includes(others_city[i])) {
										city_arr.push(others_city[i]);
									}
									
								}
							}
							for (var i = 0; i < city_arr.length; i++) {
								cityElement.options[cityElement.length] = new Option(city_arr[i], city_arr[i]);
								if (city_arr[i] == city) {
									cityElement.selectedIndex = parseInt(i) + 1;
								}
							}
						}
					});
				}	
			}
			else{
				var city_arr = new Array("Others");
				var others_city = new Array();
				var post_url ="common_changes.php?get_city=1&get_district="+district;
				jQuery.ajax({
					url:post_url,success:function(result){
						result =result.replace('\r\n', '');
						if(result != '' && result != 'NULL')
						{
							others_city =result.split(',');
							for(var i = 0;i < others_city.length;i++)
							{
								others_city[i] =others_city[i].replace('\r\n', '');
								if(!city_arr.includes(others_city[i])) {
									city_arr.push(others_city[i]);
								}
							}
						}

						for (var i = 0; i < city_arr.length; i++) {
							cityElement.options[cityElement.length] = new Option(city_arr[i], city_arr[i]);
							if (city_arr[i] == city) {
								cityElement.selectedIndex = parseInt(i) + 1;
							}
						}	
					}
				});
			}
		}
	}
}