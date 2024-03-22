<?php
//определение ассоциативного массива транзакций
$transactions = [
 [
 "transaction_id" => 1, // id
 "transaction_date" => "2019-01-01", // дата
 "transaction_amount" => 100.00, // сумма транзакции
 "transaction_description" => "Payment for groceries", // описание
 "merchant_name" => "SuperMart", // название организации
 ],
 [
 "transaction_id" => 2,
 "transaction_date" => "2020-02-15",
 "transaction_amount" => 75.50,
 "transaction_description" => "Dinner with friends",
 "merchant_name" => "Local Restaurant",
 ],
 [
 "transaction_id" => 3,
 "transaction_date" => "2021-05-15",
 "transaction_amount" => 79.80,
 "transaction_description" => "Going to cinema",
 "merchant_name" => "Cinema World",
 ],
 [
 "transaction_id" => 4,
 "transaction_date" => "2021-08-16",
 "transaction_amount" => 123.20,
 "transaction_description" => "Buying computer components",
 "merchant_name" => "Computer shop",
 ]
];
?>
<table border="1">
 <tr style="background-color: #a6a6a6; color: #252525">
 <th colspan="4">Оценки студентов</th>
 </tr>
 <tr style="background-color: #a6a6a6; color: #252525">
 <th>ID</th>
 <th>Дата</th>
 <th>Сумма транзакции</th>
 <th>Описание транзакции</th>
 <th>Название организации</th>
 </tr>
 <?php
 foreach ($transactions as $transaction) { ?>
 <tr>
            <td><?php echo $transaction["transaction_id"]; ?></td>
            <td><?php echo $transaction["transaction_date"]; ?></td>
            <td><?php echo $transaction["transaction_amount"]; ?></td>
            <td><?php echo $transaction["transaction_description"]; ?></td>
            <td><?php echo $transaction["merchant_name"]; ?></td>
 </tr>

<?php } ?>
</table>
<?php
 function calculateTotalAmount($transactions){
   return array_reduce($transactions, function ($sum, $transaction) {
      return $sum + $transaction["transaction_amount"];
  }, 0);
 }
 function calculateAverage($transactions) {
    return calculateTotalAmount($transactions)/count($transactions);
 }
 function mapTransactionDescriptions($transactions){
   return array_map(function ($transaction) {
      return $transaction["transaction_description"];
  }, $transactions);
 }
 echo "Total amount in transactions = ".calculateTotalAmount($transactions)."<br \>";  
 echo "Average amount in a transaction = ". calculateAverage($transactions)."<br \>";
 print_r (mapTransactionDescriptions($transactions));
 echo "<br \>";
  

