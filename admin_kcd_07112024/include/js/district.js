var district_state_arr = new Array("Andaman And Nicobar Islands", "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chandigarh", "Chhattisgarh", "Dadra And Nagar Haveli", "Daman And Diu", "Delhi", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu And Kashmir", "Jharkhand", "Karnataka", "Kerala", "Ladakh", "Lakshadweep", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Orissa", "Pondicherry", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura", "Uttar Pradesh", "Uttaranchal", "West Bengal");

var district_index = new Array();
district_index[1]="Nicobars|North And Middle Andaman|South Andamans";
district_index[2]="Alluri Sitharama Raju|Anakapalli|Ananthapuramu|Annamayya|Bapatla|Chittoor|Dr. B.R. Ambedkar Konaseema|East Godavari|Eluru|Guntur|Kakinada|Krishna|Kurnool|Nandyal|Ntr|Palnadu|Parvathipuram Manyam|Prakasam|Srikakulam|Sri Potti Sriramulu Nellore|Sri Sathya Sai|Tirupati|Visakhapatnam|Vizianagaram|West Godavari|Y.S.R.";
district_index[3]="Anjaw|Changlang|Dibang Valley|East Kameng|East Siang|Kamle|Kra Daadi|Kurung Kumey|Leparada|Lohit|Longding|Lower Dibang Valley|Lower Siang|Lower Subansiri|Namsai|Pakke Kessang|Papum Pare|Shi Yomi|Siang|Tawang|Tirap|Upper Siang|Upper Subansiri|West Kameng|West Siang";
district_index[4]="Bajali|Baksa|Barpeta|Biswanath|Bongaigaon|Cachar|Charaideo|Chirang|Darrang|Dhemaji|Dhubri|Dibrugarh|Dima Hasao|Goalpara|Golaghat|Hailakandi|Hojai|Jorhat|Kamrup|Kamrup Metro|Karbi Anglong|Karimganj|Kokrajhar|Lakhimpur|Majuli|Marigaon|Nagaon|Nalbari|Sivasagar|Sonitpur|South Salmara Mancachar|Tamulpur|Tinsukia|Udalguri|West Karbi Anglong";
district_index[5]="Araria|Arwal|Aurangabad|Banka|Begusarai|Bhagalpur|Bhojpur|Buxar|Darbhanga|Gaya|Gopalganj|Jamui|Jehanabad|Kaimur (Bhabua)|Katihar|Khagaria|Kishanganj|Lakhisarai|Madhepura|Madhubani|Munger|Muzaffarpur|Nalanda|Nawada|Pashchim Champaran|Patna|Purbi Champaran|Purnia|Rohtas|Saharsa|Samastipur|Saran|Sheikhpura|Sheohar|Sitamarhi|Siwan|Supaul|Vaishali";
district_index[6]="Chandigarh";
district_index[7]="Balod|Balodabazar-Bhatapara|Balrampur Ramanujganj|Bastar|Bemetara|Bijapur|Bilaspur|Dakshin Bastar Dantewada|Dhamtari|Durg|Gariyaband|Gaurela Pendra Marwahi|Janjgir-Champa|Jashpur|Kabeerdham|Khairagarh Chhuikhadan Gandai|Kondagaon|Korba|Korea|Mahasamund|Manendragarh Chirmiri Bharatpur Mcb|Mohla Manpur Ambagarh Chouki|Mungeli|Narayanpur|Raigarh|Raipur|Rajnandgaon|Sakti|Sarangarh Bilaigarh|Sukma|Surajpur|Surguja|Uttar Bastar Kanker";
district_index[8]="Dadra And Nagar Haveli";
district_index[9]="Daman|Diu";
district_index[10]="Central|East|New Delhi|North|North East|North West|Shahdara|South|South East|South West|West";
district_index[11]="North Goa|South Goa";
district_index[12]="Ahmadabad|Amreli|Anand|Arvalli|Banas Kantha|Bharuch|Bhavnagar|Botad|Chhotaudepur|Dang|Devbhumi Dwarka|Dohad|Gandhinagar|Gir Somnath|Jamnagar|Junagadh|Kachchh|Kheda|Mahesana|Mahisagar|Morbi|Narmada|Navsari|Panch Mahals|Patan|Porbandar|Rajkot|Sabar Kantha|Surat|Surendranagar|Tapi|Vadodara|Valsad";
district_index[13]="Ambala|Bhiwani|Charki Dadri|Faridabad|Fatehabad|Gurugram|Hisar|Jhajjar|Jind|Kaithal|Karnal|Kurukshetra|Mahendragarh|Nuh|Palwal|Panchkula|Panipat|Rewari|Rohtak|Sirsa|Sonipat|Yamunanagar";
district_index[14]="Bilaspur|Chamba|Hamirpur|Kangra|Kinnaur|Kullu|Lahul And Spiti|Mandi|Shimla|Sirmaur|Solan|Una";
district_index[15]="Anantnag|Bandipora|Baramulla|Budgam|Doda|Ganderbal|Jammu|Kathua|Kishtwar|Kulgam|Kupwara|Poonch|Pulwama|Rajouri|Ramban|Reasi|Samba|Shopian|Srinagar|Udhampur";
district_index[16]="Bokaro|Chatra|Deoghar|Dhanbad|Dumka|East Singhbum|Garhwa|Giridih|Godda|Gumla|Hazaribagh|Jamtara|Khunti|Koderma|Latehar|Lohardaga|Pakur|Palamu|Ramgarh|Ranchi|Sahebganj|Saraikela Kharsawan|Simdega|West Singhbhum";
district_index[17]="Bagalkote|Ballari|Belagavi|Bengaluru Rural|Bengaluru Urban|Bidar|Chamarajanagara|Chikkaballapura|Chikkamagaluru|Chitradurga|Dakshina Kannada|Davangere|Dharwad|Gadag|Hassan|Haveri|Kalaburagi|Kodagu|Kolar|Koppal|Mandya|Mysuru|Raichur|Ramanagara|Shivamogga|Tumakuru|Udupi|Uttara Kannada|Vijayanagar|Vijayapura|Yadgir";
district_index[18]="Alappuzha|Ernakulam|Idukki|Kannur|Kasaragod|Kollam|Kottayam|Kozhikode|Malappuram|Palakkad|Pathanamthitta|Thiruvananthapuram|Thrissur|Wayanad";
district_index[19]="Kargil|Leh Ladakh";
district_index[20]="Lakshadweep";
district_index[21]="Agar-Malwa|Alirajpur|Anuppur|Ashoknagar|Balaghat|Barwani|Betul|Bhind|Bhopal|Burhanpur|Chhatarpur|Chhindwara|Damoh|Datia|Dewas|Dhar|Dindori|Guna|Gwalior|Harda|Indore|Jabalpur|Jhabua|Katni|Khandwa (East Nimar)|Khargone (West Nimar)|Maihar|Mandla|Mandsaur|MAUGANJ|Morena|Narmadapuram|Narsimhapur|Neemuch|Niwari|Pandhurna|Panna|Raisen|Rajgarh|Ratlam|Rewa|Sagar|Satna|Sehore|Seoni|Shahdol|Shajapur|Sheopur|Shivpuri|Sidhi|Singrauli|Tikamgarh|Ujjain|Umaria|Vidisha";

district_index[22]="Ahmednagar|Akola|Amravati|Beed|Bhandara|Buldhana|Chandrapur|Chhatrapati Sambhajinagar|Dharashiv|Dhule|Gadchiroli|Gondia|Hingoli|Jalgaon|Jalna|Kolhapur|Latur|Mumbai|Mumbai Suburban|Nagpur|Nanded|Nandurbar|Nashik|Palghar|Parbhani|Pune|Raigad|Ratnagiri|Sangli|Satara|Sindhudurg|Solapur|Thane|Wardha|Washim|Yavatmal";
district_index[23]="Bishnupur|Chandel|Churachandpur|Imphal East|Imphal West|Jiribam|Kakching|Kamjong|Kangpokpi|Noney|Pherzawl|Senapati|Tamenglong|Tengnoupal|Thoubal|Ukhrul";
district_index[24]="Eastern West Khasi Hills|East Garo Hills|East Jaintia Hills|East Khasi Hills|North Garo Hills|Ri Bhoi|South Garo Hills|South West Garo Hills|South West Khasi Hills|West Garo Hills|West Jaintia Hills|West Khasi Hills";
district_index[25]="Aizawl|Champhai|Hnahthial|Khawzawl|Kolasib|Lawngtlai|Lunglei|Mamit|Saitual|Serchhip|Siaha";
district_index[26]="Chumoukedima|Dimapur|Kiphire|Kohima|Longleng|Mokokchung|Mon|Niuland|Noklak|Peren|Phek|Shamator|Tseminyu|Tuensang|Wokha|Zunheboto";
district_index[27]="Anugul|Balangir|Baleshwar|Bargarh|Bhadrak|Boudh|Cuttack|Deogarh|Dhenkanal|Gajapati|Ganjam|Jagatsinghapur|Jajapur|Jharsuguda|Kalahandi|Kandhamal|Kendrapara|Kendujhar|Khordha|Koraput|Malkangiri|Mayurbhanj|Nabarangpur|Nayagarh|Nuapada|Puri|Rayagada|Sambalpur|Sonepur|Sundargarh";
district_index[28]="Karaikal|Mahe|Pondicherry|Yanam";
district_index[29]="Amritsar|Barnala|Bathinda|Faridkot|Fatehgarh Sahib|Fazilka|Ferozepur|Gurdaspur|Hoshiarpur|Jalandhar|Kapurthala|Ludhiana|Malerkotla|Mansa|Moga|Pathankot|Patiala|Rupnagar|Sangrur|S.A.S Nagar|Shahid Bhagat Singh Nagar|Sri Muktsar Sahib|Tarn Taran";
district_index[30]="Ajmer|Alwar|Anoopgarh|Balotra|Banswara|Baran|Barmer|Beawar|Bharatpur|Bhilwara|Bikaner|Bundi|Chittorgarh|Churu|Dausa|Deeg|Dholpur|Didwana Kuchaman|Dudu|Dungarpur|Ganganagar|Gangapurcity|Hanumangarh|Jaipur|Jaipur Gramin|Jaisalmer|Jalore|Jhalawar|Jhunjhunu|Jodhpur|Jodhpur Gramin|Karauli|Kekri|Khairthal-Tijara|Kota|Kotputli-Behror|Nagaur|Neem Ka Thana|Pali|Phalodi|Pratapgarh|Rajsamand|Salumbar|Sanchor|Sawai Madhopur|Shahpura|Sikar|Sirohi|Tonk|Udaipur";
district_index[31]="Gangtok|Gyalshing|Mangan|Namchi|Pakyong|Soreng";
district_index[32]="Ariyalur|Chengalpattu|Chennai|Coimbatore|Cuddalore|Dharmapuri|Dindigul|Erode|Kallakurichi|Kanchipuram|Kanniyakumari|Karur|Krishnagiri|Madurai|Mayiladuthurai|Nagapattinam|Namakkal|Perambalur|Pudukkottai|Ramanathapuram|Ranipet|Salem|Sivaganga|Tenkasi|Thanjavur|Theni|The Nilgiris|Thiruvallur|Thiruvarur|Tiruchirappalli|Tirunelveli|Tirupathur|Tiruppur|Tiruvannamalai|Tuticorin|Vellore|Villupuram|Virudhunagar";
district_index[33]="Adilabad|Bhadradri Kothagudem|Hanumakonda|Hyderabad|Jagitial|Jangoan|Jayashankar Bhupalapally|Jogulamba Gadwal|Kamareddy|Karimnagar|Khammam|Kumuram Bheem Asifabad|Mahabubabad|Mahabubnagar|Mancherial|Medak|Medchal Malkajgiri|Mulugu|Nagarkurnool|Nalgonda|Narayanpet|Nirmal|Nizamabad|Peddapalli|Rajanna Sircilla|Ranga Reddy|Sangareddy|Siddipet|Suryapet|Vikarabad|Wanaparthy|Warangal|Yadadri Bhuvanagiri";
district_index[34]="Dhalai|Gomati|Khowai|North Tripura|Sepahijala|South Tripura|Unakoti|West Tripura";
district_index[35]="Agra|Aligarh|Ambedkar Nagar|Amethi|Amroha|Auraiya|Ayodhya|Azamgarh|Baghpat|Bahraich|Ballia|Balrampur|Banda|Bara Banki|Bareilly|Basti|Bhadohi|Bijnor|Budaun|Bulandshahr|Chandauli|Chitrakoot|Deoria|Etah|Etawah|Farrukhabad|Fatehpur|Firozabad|Gautam Buddha Nagar|Ghaziabad|Ghazipur|Gonda|Gorakhpur|Hamirpur|Hapur|Hardoi|Hathras|Jalaun|Jaunpur|Jhansi|Kannauj|Kanpur Dehat|Kanpur Nagar|Kasganj|Kaushambi|Kheri|Kushinagar|Lalitpur|Lucknow|Mahoba|Mahrajganj|Mainpuri|Mathura|Mau|Meerut|Mirzapur|Moradabad|Muzaffarnagar|Pilibhit|Pratapgarh|Prayagraj|Rae Bareli|Rampur|Saharanpur|Sambhal|Sant Kabir Nagar|Shahjahanpur|Shamli|Shrawasti|Siddharthnagar|Sitapur|Sonbhadra|Sultanpur|Unnao|Varanasi";
district_index[36]="Almora|Bageshwar|Chamoli|Champawat|Dehradun|Haridwar|Nainital|Pauri Garhwal|Pithoragarh|Rudra Prayag|Tehri Garhwal|Udam Singh Nagar|Uttar Kashi";
district_index[37]="Alipurduar|Bankura|Birbhum|Cooch Behar|Dakshin Dinajpur|Darjeeling|Hooghly|Howrah|Jalpaiguri|Jhargram|Kalimpong|Kolkata|Malda|Murshidabad|Nadia|North 24 Parganas|Paschim Bardhaman|Paschim Medinipur|Purba Bardhaman|Purba Medinipur|Purulia|South 24 Parganas|Uttar Dinajpur";


function getDistricts(form_name, district, city) {
	if (jQuery('form[name="'+form_name+'_form"]').find('select[name="district"]').length > 0) {
		var selectedStateIndex = document.forms[form_name+"_form"]["state"].selectedIndex;
		var state = district_state_arr[selectedStateIndex - 1];
		var selected_state = document.forms[form_name+"_form"]["state"].value;
		var districtsElement = document.forms[form_name+"_form"]["district"];
		
		districtsElement.length = 0;
		districtsElement.options[0] = new Option('Select', '');
		districtsElement.selectedIndex = 0;
		if (state == selected_state) {
			var district_arr = district_index[selectedStateIndex].split("|");
			for (var i = 0; i < district_arr.length; i++) {
				districtsElement.options[districtsElement.length] = new Option(district_arr[i], district_arr[i]);
				if (district_arr[i] == district) {
					districtsElement.selectedIndex = parseInt(i) + 1;
				}
			}
            getCities(form_name,district, city);
			districtsElement.onchange = function () {
				getCities(form_name,district, city);
			};
		}
	}
}

function getLRPartyDistricts(form_name, party_name, district, city) {
	if (jQuery('form[name="'+form_name+'_form"]').find('select[name="'+party_name+'_district"]').length > 0) {
		var selectedStateIndex = document.forms[form_name+"_form"][party_name+"_state"].selectedIndex;
		var state = district_state_arr[selectedStateIndex - 1];
		var selected_state = document.forms[form_name+"_form"][party_name+"_state"].value;
		var districtsElement = document.forms[form_name+"_form"][party_name+"_district"];
		
		districtsElement.length = 0;
		districtsElement.options[0] = new Option('Select', '');
		districtsElement.selectedIndex = 0;
		if (state == selected_state) {
			var district_arr = district_index[selectedStateIndex].split("|");
			for (var i = 0; i < district_arr.length; i++) {
				districtsElement.options[districtsElement.length] = new Option(district_arr[i], district_arr[i]);
				if (district_arr[i] == district) {
					districtsElement.selectedIndex = parseInt(i) + 1;
				}
			}
            getLRPartyCities(form_name, party_name, district, city);
			districtsElement.onchange = function () {
				getLRPartyCities(form_name, party_name, district, city);
			};
		}
	}
}
