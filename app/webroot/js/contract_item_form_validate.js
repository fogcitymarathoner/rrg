function validateForm()
{
	var amt=parseFloat(document.forms["addedit_contract_item"]["ContractsItemAmt"].value)
	var cost=parseFloat(document.forms["addedit_contract_item"]["ContractsItemCost"].value)
	var description=document.forms["addedit_contract_item"]["ContractsItemDescription"].value
	#alert(amt+' '+cost+' '+description)
	if (amt==null || cost==null || description==null)
	{
		alert("Billout, Wage, and description must be filled out");
		return false;
	}
	if (amt=='' || cost=='' || description=='')
	{
		alert("Billout, Wage, and description must be filled out");
		return false;
	}
	if (amt < cost)
	{
		alert("Billout "+amt+" must be more than Wage "+cost);
		return false;
	}
	return true
}
