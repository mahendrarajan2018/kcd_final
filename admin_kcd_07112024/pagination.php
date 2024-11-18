<div class="pagination_cover my-3"> 
<script type="text/javascript"> 
  function pagination(page_number, page_limit) {
    var check_login_session = 1;
    var post_url = "dashboard_changes.php?check_login_session=1";	
    jQuery.ajax({url: post_url, success: function(check_login_session){
      if(check_login_session == 1) {
        if(jQuery('input[name="page_number"]').length > 0) {
          jQuery('input[name="page_number"]').val(page_number);
        }
        if(jQuery('input[name="page_limit"]').length > 0) {
          jQuery('input[name="page_limit"]').val(page_limit);
        }
        table_listing_records_filter();
      }
      else {
        window.location.reload();
      }
    }});	
  }  
  function change_pagination_limit(page_limit) {
    var check_login_session = 1;
    var post_url = "dashboard_changes.php?check_login_session=1";	
    jQuery.ajax({url: post_url, success: function(check_login_session){
      if(check_login_session == 1) {
        if(jQuery('input[name="page_number"]').length > 0) {
          jQuery('input[name="page_number"]').val(1);
        }
        if(jQuery('input[name="page_limit"]').length > 0) {
          jQuery('input[name="page_limit"]').val(page_limit);
        }
        table_listing_records_filter();
      }
      else {
        window.location.reload();
      }
    }});	
  }
</script>

<link href="include/select2/css/select2.min.css" rel="stylesheet" />
<link href="include/select2/css/select2-bootstrap4.min.css" rel="stylesheet">
  
  <div class="row mx-0 d-flex align-items-center justify-content-center">
      <div class="col-2">
          Page Limit:
      </div>
      <div class="col-4">
          <?php
              $limit_count = 0;
              $limit_count = count($GLOBALS['page_limit_list']);
              $page_limit_list = $GLOBALS['page_limit_list'];
              if(!empty($limit_count)) {
          ?>
                  <select name="page_number" class="form-control" onchange="Javascript:change_pagination_limit(this.value);">
                      <?php for($l = 0; $l < $limit_count; $l++) { ?>
                          <option value="<?php if(!empty($page_limit_list[$l])) { echo $page_limit_list[$l]; } ?>" <?php if(!empty($page_limit) && !empty($page_limit_list[$l])) { if($page_limit_list[$l] == $page_limit) { ?> selected="selected" <?php } } ?> > <?php if(!empty($page_limit_list[$l])) { echo $page_limit_list[$l]; } ?> </option>
                      <?php } ?>
                  </select>
          <?php		
              }
          ?>
      </div>
      <div class="col-2 col-md-4 text-right">
          Page No:
      </div>
      <div class="col-4 col-md-2">
          <?php
              $page_count = 0;
              $page_count = ceil($total_pages / $page_limit);
              if(!empty($page_count)) {
          ?>
                  <select name="page_number" class="form-control" onchange="Javascript:pagination(this.value, '<?php if(!empty($page_limit)) { echo $page_limit; } ?>');">
                      <?php for($p = 1; $p <= $page_count; $p++) { ?>
                          <option value="<?php echo $p; ?>" <?php if(!empty($page_number)) { if($p == $page_number) { ?> selected="selected" <?php } } ?> > <?php echo $p; ?> </option>
                      <?php } ?>
                  </select>
          <?php		
              }
          ?>
      </div>
  </div>
  <script src="include/select2/js/select2.min.js"></script>
  <script src="include/select2/js/select.js"></script>
</div> 

<?php
  /*
?>
<style>
.wrapper {
  display: block;
}

.pager__indexs {
  list-style-type: none;
  margin: 0;
  padding: 0;
  float: right;
}
.pager__indexs li {
  display: inline-block;
  margin: 5px;
}

.viewby {
  padding: 0 10px 0 100px;
}

.pager__button {
	background: none;
	color: #343a40;
	font-weight: bold;
	padding: 10px 15px;
	border-radius: 4px;
	font-size: 0.9rem;
	line-height: 1rem;
	border: 2px solid #343a40;
}
.pager__button:hover {
  background: #343a40;
  color: #fff;
}
.pager__button.active {
  background: #343a40;
  color: #FFFFFF;
}

.decorator {
  color: #25619b;
  padding: 8px 5px;
}

.default__results {
  padding: .25rem 0 0;
  margin: 1rem 0 0;
  border-top: 1px solid #c2e2fc;
  font-size: 1rem;
  width: 60vw;
}

.default__label {
  font-size: 0.875rem;
  padding-left: .5rem;
}

.default__row {
  padding: 0.5rem;
  margin-bottom: 0.5rem;
  border-bottom: 1px solid #c2e2fc;
}

.default__select {
  background: #fff;
  color: #25619b;
  border: 1px solid #25619b;
  border-radius: 3px;
  padding: .25rem .5rem;
  margin: 0 0 0 .5rem;
}

a {
  color: #25619b;
  text-decoration: underline;
}
a:hover {
  text-decoration: none;
}
#pagination_list .pager__indexs:last-child, #pagination_list .default__results, #pagination_list .default__label { display: none; }
</style>

	<div id="pagination_list" />
    <script type="text/javascript">
var dataSet = {
  length: <?php if(!empty($total_pages)) { echo $total_pages; } ?>,
  current: <?php if(!empty($page_number)) { echo $page_number; } ?>,
  viewBy: <?php if(!empty($page_limit)) { echo $page_limit; } ?> };

Pagination = props => {
  const { current, total, onChangeCurrent } = props;
  const PgButton = i => {
    let bstate = "pager__button ";
    if (i === current) bstate += "active";
    return (
      React.createElement("li", null,
      React.createElement("button", { className: bstate, onClick: () => onChangeCurrent(i) }, i)));
  };
  const generateLinks = () => {
    const links = [];
    const decorator = React.createElement("li", { className: "decorator" }, "...");
    const end_total = total - 4;
    const start_min = current < 5;
    const inout = start_min || current > end_total;
    let start = inout ? start_min ? 1 : end_total : current - 1;
    let end = current > end_total ? total : current + 2;
    if (end >= total - 1) end = total + 1;
    if (current > end_total) start = end_total;
    if (current > 4) {
      links.push(PgButton(1));
      links.push(decorator);
    }
    for (let i = start; i < end; i++) {
      if (i > 0) links.push(PgButton(i));
    }
    if (end < total) {
      if (end < total - 1) links.push(decorator);
      links.push(PgButton(total));
    }
    return links;
  };
  const ButtonIU = generateLinks();
  const PgHeader =
  React.createElement("li", null,
  React.createElement("button", {
    className: "pager__button",
    onClick: () => {
      onChangeCurrent(current - 1);
    } },

  "< Previous"));

  const PgFooter =
  React.createElement("li", null,
  React.createElement("button", {
    className: "pager__button",
    onClick: () => {
      onChangeCurrent(current + 1 > total ? total : current + 1);
    } },

  "Next >"));

  return (
    React.createElement("ul", { className: "pager__indexs" },
    current >= 2 && PgHeader,
    ButtonIU,
    current !== total && PgFooter));
};

var Main = () => {
  const options = [3, 6, 9, 12];
  const [current, setCurrent] = React.useState(dataSet.current);
  const [viewBy, setViewBy] = React.useState(options[0]);

  const opts = options.map(item => {
    return React.createElement("option", { value: item }, item);
  });
  const dropDown =
  React.createElement("select", {
    className: "default__select",
    value: viewBy,
    onChange: e => setViewBy(e.target.value) }, opts);


  const fakeResults = [];
  const pageTotal = Math.ceil(dataSet.length / dataSet.viewBy);
  return (
    React.createElement("div", { className: "wrapper" },
    React.createElement(Pagination, {
      current: current,
      total: pageTotal,
      onChangeCurrent: num => displayPage(num) }),	
    React.createElement(Pagination, {
      current: current,
      total: pageTotal,
      onChangeCurrent: num => displayPage(num) })
	));

	function displayPage(number) {
		setCurrent(parseInt(number, 10));
		pagination(number, dataSet.viewBy);
	}
};

ReactDOM.render(React.createElement(Main, null), document.getElementById("pagination_list"));	
    </script>
</div>
<?php */ ?>