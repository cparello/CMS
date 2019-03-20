function printPage(){
//window.print();

$('#page-wrap').printThis({debug: false,importCSS: true, printContainer: true, loadCSS: "../css/contract.css", pageTitle: "", removeInline: false});
}
