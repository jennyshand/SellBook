/*
Some examples of stored procedures and functions I wrote 
for a book store database.
*/

create or replace function next_ord_needed_id return integer as
   max_ord_id integer;
begin
   select max(ord_needed_id)
   into max_ord_id
   from order_needed;

   if max_ord_id is not null then
      return max_ord_id + 1;
   else
      return 1;
   end if;
end;
/
show errors


create or replace function is_on_order(isbn_val varchar2) return boolean as
   order_status char(1);
begin
   select on_order
   into order_status
   from title
   where isbn = isbn_val;

   if (order_status = 'T') then
      return TRUE;
   else
      return FALSE;
   end if;
exception
   when no_data_found then
      return FALSE;
end;
/
show errors


create or replace procedure insert_order_needed(isbn_val varchar2, qty_to_order$
   order_id integer;
begin
   order_id := next_ord_needed_id();

   insert into order_needed
   values
   (order_id, isbn_val, qty_to_order, sysdate, null);
end;
/
show errors


create or replace function pending_order_needed(isbn_val varchar2) return boole$
   order_placed date;
begin
   select date_placed
   into order_placed
   from order_needed
   where isbn = isbn_val;

   if order_placed is null then
      return TRUE;
   else
      return FALSE;
   end if;
exception
   when no_data_found then
      return FALSE;
   when too_many_rows then
      return FALSE;
end;
/
show errors

