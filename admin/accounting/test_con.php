<?php
header('Content-Type: text/xml');
$xml = '
<?xml version="1.0" encoding="utf-8"?>
		<?qbxml version="2.0"?>
		<QBXML>
			<QBXMLMsgsRq onError="stopOnError">
				<SalesReceiptAddRq requestID="45">
					<SalesReceiptAdd>
						<CustomerRef>
							<FullName>Keith Palmer Jr.</FullName>
						</CustomerRef>
						<TxnDate>2009-01-09</TxnDate>
						<RefNumber>16466</RefNumber>
						<BillAddress>
							<Addr1>Keith Palmer Jr.</Addr1>
							<Addr3>134 Stonemill Road</Addr3>
							<City>Storrs-Mansfield</City>
							<State>CT</State>
							<PostalCode>06268</PostalCode>
							<Country>United States</Country>
						</BillAddress>
						<SalesReceiptLineAdd>
							<ItemRef>
								<FullName>Gift Certificate</FullName>
							</ItemRef>
							<Desc>$25.00 gift certificate</Desc>
							<Quantity>1</Quantity>
							<Rate>25.00</Rate>
							<SalesTaxCodeRef>
								<FullName>NON</FullName>
							</SalesTaxCodeRef>
						</SalesReceiptLineAdd>
						<SalesReceiptLineAdd>
							<ItemRef>
								<FullName>Book</FullName>
							</ItemRef>
							<Desc>The Hitchhiker\'s Guide to the Galaxy</Desc>
							<Amount>19.95</Amount>
							<SalesTaxCodeRef>
								<FullName>TAX</FullName>
							</SalesTaxCodeRef>
						</SalesReceiptLineAdd>
					</SalesReceiptAdd>
				</SalesReceiptAddRq>
			</QBXMLMsgsRq>
		</QBXML>';
$xml = trim($xml);
echo"$xml";
?>